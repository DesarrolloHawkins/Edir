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
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|string|max:50',
            'datetime' => 'required|date',
            'descripcion' => 'required|string',
            'comunidad_id' => 'nullable|exists:comunidad,id',
            'metodo_envio' => 'required|in:email,whatsapp',
            'ruta_archivo' => 'nullable|file|max:10240',
        ]);

        $data = $request->all();
        $data['admin_user_id'] = Auth::id();
        $data['user_id'] = Auth::id();
        
        $archivoPath = null;
        if ($request->hasFile('ruta_archivo')) {
            $archivoPath = $request->file('ruta_archivo')->store('notificaciones');
            $data['ruta_archivo'] = $archivoPath;
        }

        $alerta = Alertas::with('comunidad')->create($data);

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

        // Asociar alerta a los usuarios
        $userIds = $usuarios->pluck('id');
        if ($userIds->isNotEmpty()) {
            $alerta->users()->attach($userIds, ['status' => 0]);
        }

        // Enviar por el método seleccionado
        if ($request->metodo_envio == 'email') {
            $totalUsuarios = $usuarios->count();
            
            if ($totalUsuarios == 0) {
                return redirect()->route('notificaciones.index')
                    ->with('warning', 'Notificación creada, pero no se encontraron usuarios con email para enviar.');
            }

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
            
            foreach ($usuariosChunks as $loteIndex => $lote) {
                foreach ($lote as $usuario) {
                    // Todos los emails del mismo lote se envían al mismo tiempo
                    // pero con delay entre lotes para evitar spam
                    EnviarNotificacionEmail::dispatch($alerta, $usuario->id, $archivoPath)
                        ->delay(now()->addSeconds($delay));
                }
                
                // Incrementar delay para el siguiente lote
                $delay += $delayEntreLotes;
            }
            
            Log::info("Notificación {$alerta->id} programada para envío a {$totalUsuarios} usuarios de {$comunidadNombre}");
            
            $mensaje = "Notificación creada correctamente. ";
            $mensaje .= "Se están enviando {$totalUsuarios} emails a usuarios de {$comunidadNombre} en segundo plano. ";
            $mensaje .= "El proceso puede tardar unos minutos.";
            
            return redirect()->route('notificaciones.index')->with('success', $mensaje);
        } elseif ($request->metodo_envio == 'whatsapp') {
            // WhatsApp no disponible aún
            return redirect()->route('notificaciones.index')
                ->with('warning', 'Notificación creada, pero WhatsApp no está disponible aún. La API está pendiente de configuración.');
        }

        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada correctamente.');
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
