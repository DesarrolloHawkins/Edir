<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alertas;
use App\Models\Comunidad;
use App\Models\User;
use App\Mail\NotificacionEmail;
use App\Jobs\EnviarNotificacionEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class NotificacionesController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $comunidadId = $request->get('comunidad_id');
        $search = $request->get('search');

        $query = Alertas::query();

        if ($comunidadId) {
            $query->where('comunidad_id', $comunidadId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        $notificaciones = $query->orderBy('datetime', 'desc')->paginate($perPage);
        $comunidades = Comunidad::all();

        return view('admin.notificaciones.index', compact('notificaciones', 'comunidades', 'perPage', 'comunidadId', 'search'));
    }

    public function create()
    {
        $comunidades = Comunidad::all();
        return view('admin.notificaciones.create', compact('comunidades'));
    }

    public function store(Request $request)
    {
        try {
            // Log al inicio para rastrear la ejecución
            \Log::info('Iniciando creación de notificación', [
                'user_id' => Auth::id(),
                'request_data' => $request->except(['ruta_archivo', 'password', '_token'])
            ]);
            
            $request->validate([
                'titulo' => 'required|string|max:255',
                'tipo' => 'required|string|max:50',
                'datetime' => 'required|date',
                'descripcion' => 'required|string',
                'comunidad_id' => 'nullable|exists:comunidad,id',
                'metodo_envio' => 'required|in:email,whatsapp',
                'ruta_archivo' => 'nullable|file|max:10240',
            ]);
            
            \Log::info('Validación pasada correctamente');

            // Preparar datos solo con campos permitidos en fillable
            // Convertir datetime-local a formato de base de datos
            $datetime = $request->datetime ? date('Y-m-d H:i:s', strtotime($request->datetime)) : now();
            
            $data = [
                'admin_user_id' => Auth::id(),
                'user_id' => Auth::id(),
                'titulo' => $request->titulo,
                'tipo' => $request->tipo,
                'datetime' => $datetime,
                'descripcion' => $request->descripcion,
                'comunidad_id' => $request->comunidad_id ?: null,
                'seccion_id' => null, // Las notificaciones no tienen sección
                'url' => null,
            ];
            
            $archivoPath = null;
            if ($request->hasFile('ruta_archivo')) {
                $archivoPath = $request->file('ruta_archivo')->store('notificaciones', 'public');
                $data['ruta_archivo'] = $archivoPath;
            }

            \Log::info('Datos preparados, creando alerta');
            $alerta = Alertas::create($data);
            \Log::info('Alerta creada con ID: ' . $alerta->id);

            // Determinar a qué usuarios enviar la notificación
            $usuarios = collect();
            $comunidadNombre = 'Todas las comunidades';
            
            if ($request->comunidad_id) {
                // Enviar solo a usuarios de la comunidad específica
                $comunidad = Comunidad::find($request->comunidad_id);
                $comunidadNombre = $comunidad ? $comunidad->nombre : 'Comunidad desconocida';
                
                $usuarios = User::where('comunidad_id', $request->comunidad_id)
                    ->whereNotNull('email')
                    ->where('email', '!=', '')
                    ->get();
            } else {
                // Enviar a todos los usuarios de todas las comunidades
                $usuarios = User::whereNotNull('email')
                    ->where('email', '!=', '')
                    ->get();
            }

            \Log::info('Usuarios encontrados: ' . $usuarios->count());

            // Asociar alerta a los usuarios
            $userIds = $usuarios->pluck('id');
            if ($userIds->isNotEmpty()) {
                $alerta->users()->attach($userIds, ['status' => 0]);
                \Log::info('Alerta asociada a ' . $userIds->count() . ' usuarios');
            }

            // Enviar por el método seleccionado
            if ($request->metodo_envio == 'email') {
                $totalUsuarios = $usuarios->count();
                
                if ($totalUsuarios == 0) {
                    return redirect()->route('notificaciones.index')
                        ->with('warning', 'Notificación creada, pero no se encontraron usuarios con email para enviar.');
                }

                try {
                    // Enviar emails usando colas (jobs) para procesamiento en lotes
                    // Esto evita bloqueos por envío masivo y permite rate limiting
                    // 
                    // CONFIGURACIÓN DE LOTES:
                    // - loteSize: Cantidad de emails que se envían simultáneamente
                    // - delayEntreLotes: Tiempo de espera entre lotes (en segundos)
                    // - delayInicial: Tiempo antes de enviar el primer lote
                    // 
                    // Ejemplo: 100 usuarios = 10 lotes de 10 emails
                    // Lote 1: 5s, Lote 2: 35s, Lote 3: 65s, etc.
                    // 
                    // Para ajustar la velocidad, modifica estos valores:
                    // - Más rápido: aumentar loteSize, reducir delayEntreLotes
                    // - Más lento: reducir loteSize, aumentar delayEntreLotes
                    $loteSize = 10; // Emails por lote (ajustable según límites del servidor de email)
                    $delayEntreLotes = 30; // Segundos entre lotes (ajustable para evitar spam)
                    $delayInicial = 5; // Delay inicial antes del primer lote
                    
                    $usuariosChunks = $usuarios->chunk($loteSize);
                    $delay = $delayInicial;
                    $jobsDispatched = 0;
                    $jobsFailed = 0;
                    
                    foreach ($usuariosChunks as $loteIndex => $lote) {
                        foreach ($lote as $usuario) {
                            // Todos los emails del mismo lote se envían al mismo tiempo
                            // pero con delay entre lotes para evitar spam
                            try {
                                // Verificar que la alerta tiene ID antes de dispatchar
                                if (!$alerta->id) {
                                    \Log::error("Alerta no tiene ID al intentar dispatchar email para usuario {$usuario->id}");
                                    $jobsFailed++;
                                    continue;
                                }
                                
                                $job = new EnviarNotificacionEmail($alerta, $usuario->id, $archivoPath);
                                
                                // Si hay delay, aplicarlo; si no, dispatchar inmediatamente
                                if ($delay > 0) {
                                    dispatch($job)->delay(now()->addSeconds($delay));
                                } else {
                                    dispatch($job);
                                }
                                
                                $jobsDispatched++;
                            } catch (\Exception $e) {
                                \Log::error("Error al dispatchar email para usuario {$usuario->id}: " . $e->getMessage());
                                \Log::error("Stack trace: " . $e->getTraceAsString());
                                $jobsFailed++;
                                // Continuar con el siguiente usuario aunque falle uno
                            }
                        }
                        
                        // Incrementar delay para el siguiente lote
                        $delay += $delayEntreLotes;
                    }
                    
                    if ($jobsFailed > 0) {
                        \Log::warning("{$jobsFailed} jobs fallaron al dispatchar de {$totalUsuarios} totales");
                    }
                    
                    \Log::info("Notificación {$alerta->id} programada para envío a {$totalUsuarios} usuarios de {$comunidadNombre}");
                    \Log::info("Jobs dispatchados: {$jobsDispatched}, Jobs fallidos: {$jobsFailed}");
                    
                    // Verificar que los jobs se guardaron (solo si QUEUE_CONNECTION=database)
                    $jobsEnCola = DB::table('jobs')->count();
                    \Log::info("Jobs en cola después de dispatchar: {$jobsEnCola}");
                    
                    $mensaje = "Notificación creada correctamente. ";
                    if (config('queue.default') === 'database' && $jobsEnCola > 0) {
                        $mensaje .= "Se han creado {$jobsEnCola} jobs para enviar emails a {$totalUsuarios} usuarios de {$comunidadNombre}. ";
                        $mensaje .= "Ejecuta 'php artisan queue:work' para procesarlos.";
                    } elseif (config('queue.default') === 'sync') {
                        $mensaje .= "Los emails se están enviando inmediatamente (modo sync). ";
                        $mensaje .= "Para usar colas, cambia QUEUE_CONNECTION=database en el .env";
                    } else {
                        $mensaje .= "Se están enviando {$totalUsuarios} emails a usuarios de {$comunidadNombre} en segundo plano. ";
                        $mensaje .= "El proceso puede tardar unos minutos.";
                    }
                    
                    return redirect()->route('notificaciones.index')->with('success', $mensaje);
                } catch (\Exception $e) {
                    \Log::error("Error al programar envío de emails para notificación {$alerta->id}: " . $e->getMessage());
                    \Log::error("Stack trace: " . $e->getTraceAsString());
                    
                    // Aún así, la notificación se creó correctamente
                    return redirect()->route('notificaciones.index')
                        ->with('warning', 'Notificación creada correctamente, pero hubo un problema al programar el envío de emails. Por favor, verifica la configuración de colas.');
                }
            } elseif ($request->metodo_envio == 'whatsapp') {
                // WhatsApp no disponible aún
                return redirect()->route('notificaciones.index')
                    ->with('warning', 'Notificación creada, pero WhatsApp no está disponible aún. La API está pendiente de configuración.');
            }

            return redirect()->route('notificaciones.index')->with('success', 'Notificación creada correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación al crear notificación', [
                'errors' => $e->errors(),
                'user_id' => Auth::id()
            ]);
            throw $e; // Re-lanzar para que Laravel maneje la respuesta de validación
        } catch (\Exception $e) {
            \Log::error('Error inesperado al crear notificación', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);
            
            return redirect()->route('notificaciones.index')
                ->with('error', 'Error al crear la notificación: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $notificacion = Alertas::findOrFail($id);
        $comunidades = Comunidad::all();
        return view('admin.notificaciones.edit', compact('notificacion', 'comunidades'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|string|max:50',
            'datetime' => 'required|date',
            'descripcion' => 'required|string',
            'comunidad_id' => 'nullable|exists:comunidad,id',
            'ruta_archivo' => 'nullable|file',
        ]);

        $notificacion = Alertas::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('ruta_archivo')) {
            $data['ruta_archivo'] = $request->file('ruta_archivo')->store('notificaciones');
        }

        $notificacion->update($data);

        return redirect()->route('notificaciones.index')->with('success', 'Notificación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $notificacion = Alertas::findOrFail($id);
        $notificacion->delete();

        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada correctamente.');
    }
}
