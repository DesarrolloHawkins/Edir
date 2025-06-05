<?php

namespace App\Http\Controllers;

use App\Models\Alertas;
use App\Models\Comunidad;
use App\Models\EstadoIncidencia;
use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisosController extends Controller
{
    public function indexAdmin(Request $request)
    {
        // Usuario Logueado
        $user = Auth::user();
        if (!$user) {
            return view('noAutorizado');
        }

        // Obtener los filtros del request
        $perPage = $request->get('per_page', 10); // Por defecto, mostrar 10 registros por página
        $comunidadId = $request->get('comunidad_id'); // Filtro de comunidad
        $estadoId = $request->get('estado_id'); // Filtro de estado
        $search = $request->get('search'); // Búsqueda por texto

        // Construir la consulta
        $query = Incidencia::query();

        if ($comunidadId) {
            $query->where('comunidad_id', $comunidadId);
        }

        if ($estadoId) {
            $query->where('estado_id', $estadoId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Obtener incidencias con paginación
        $incidencias = $query->orderBy('id', 'desc')->paginate($perPage);

        // Pasar las comunidades y estados para los filtros
        $comunidades = Comunidad::all();
        $estados = EstadoIncidencia::all();

        return view('admin.incidencias.index', compact('incidencias', 'comunidades', 'estados', 'perPage', 'comunidadId', 'estadoId', 'search'));
    }


    public function showAdmin($id){
        $incidencia = Incidencia::findOrFail($id); // Buscar la incidencia por su ID
        $estados = EstadoIncidencia::all(); // Obtener los estados posibles

        return view('admin.incidencias.showAdmin', compact('incidencia', 'estados'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado_id' => 'required|exists:estado_incidencias,id',
            'fecha' => 'required|date',
        ]);

        $incidencia = Incidencia::findOrFail($id);

        // Guardar el estado anterior por si quieres comparar
        $estadoAnteriorId = $incidencia->estado_id;

        // Actualizar incidencia
        $incidencia->update($request->only('titulo', 'descripcion', 'estado_id', 'fecha'));

        // Solo si el estado cambió, lanzamos alerta
        if ($estadoAnteriorId != $request->estado_id) {
            // Crear alerta
            $alerta = Alertas::create([
                'admin_user_id' => Auth::id(),
                'titulo' => 'Cambio en el estado de una incidencia',
                'tipo' => 'incidencia',
                'datetime' => now(),
                'descripcion' => "La incidencia '{$incidencia->titulo}' ha cambiado su estado a: " . $incidencia->estado->nombre,
                'url' => route('incidencias.show', $incidencia->id),
                'comunidad_id' => $incidencia->comunidad_id,
            ]);

            // Enviar alerta a todos los usuarios de esa comunidad
            $usuarios = User::where('comunidad_id', $incidencia->comunidad_id)->get();
            foreach ($usuarios as $usuario) {
                $alerta->users()->attach($usuario->id, ['status' => 0]); // 0 = no leída
            }
        }

        return redirect()->route('incidenciasAdmin.index')->with('success', 'Incidencia actualizada correctamente.');
    }





    // USER
    public function index()
    {
        // Usuario Logueado
        $user = Auth::user();
        if(!$user) return view('noAutorizado');

        // Comunidad asociada
        // $comunidad = Comunidad::find($user->comunidad_id)->first();
        // if(!$comunidad) return view('noFound');

        // Incidencias Asociados
        $incidencias = Incidencia::where('comunidad_id', $user->comunidad_id)->get();
        $response = '';

        return view('incidencias.index', compact('response','incidencias'));
    }

    public function show($id)
    {
        $incidencia = Incidencia::findOrFail($id);
        return view('incidencias.show', compact('incidencia'));
    }
    public function create()
    {
        $response = '';
        $user = Auth::user(); // Añadimos esto
        return view('incidencias.create', compact('response', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'telefono' => 'required|string',
            'nombre' => 'required|string',
            'url' => 'nullable|string',
            // Agrega validación para imagen si la usas
        ]);

        $user = Auth::user();
        $comunidad = Comunidad::findOrFail($user->comunidad_id);

        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['comunidad_id'] = $comunidad->id;

        if ($request->hasFile('ruta_imagen')) {
            $data['ruta_imagen'] = $request->file('ruta_imagen')->store('incidencias', 'public');
        }

        $incidencia = Incidencia::create($data);
        // Crear alerta para los administradores (role = 1)
        $alerta = Alertas::create([
            'admin_user_id' => $user->id,
            'titulo' => 'Nueva incidencia: ' . $data['titulo'],
            'tipo' => 'incidencia',
            'datetime' => now(),
            'descripcion' => $data['descripcion'],
            'url' => route('incidenciasAdmin.show', $incidencia->id),
            'comunidad_id' => $comunidad->id,
        ]);

        // Obtener todos los usuarios con rol 1 (admins)
        $usuariosAdmin = User::where('role', 1)->get();

        // Adjuntar alerta con status = 0 (no leída)
        foreach ($usuariosAdmin as $admin) {
            $alerta->users()->attach($admin->id, ['status' => 0]);
        }
        return redirect()->route('incidencias.index')->with('success', 'Incidencia creada correctamente.');
    }

    public function edit($id)
    {
        $incidencia = Incidencia::findOrFail($id);
        return view('incidencias.edit', compact('incidencia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
        ]);

        $incidencia = Incidencia::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('ruta_imagen')) {
            $data['ruta_imagen'] = $request->file('ruta_imagen')->store('incidencias', 'public');
        }

        $incidencia->update($data);

        return redirect()->route('incidencias.index')->with('success', 'Incidencia actualizada correctamente.');
    }
}
