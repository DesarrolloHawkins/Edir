<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alertas;
use App\Models\Comunidad;

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
            'comunidad_id' => 'nullable|exists:comunidades,id',
            'ruta_archivo' => 'nullable|file',
        ]);

        $data = $request->all();

        if ($request->hasFile('ruta_archivo')) {
            $data['ruta_archivo'] = $request->file('ruta_archivo')->store('notificaciones');
        }

        Alertas::create($data);

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
            'comunidad_id' => 'nullable|exists:comunidades,id',
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
