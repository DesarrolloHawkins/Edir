<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use Illuminate\Http\Request;

class ComunidadesController extends Controller
{
    public function index(Request $request)
    {
        $comunidades = Comunidad::paginate(10);
        return view('admin.comunidades.index', compact('comunidades'));
    }

    public function create()
    {
        return view('admin.comunidades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'codigo' => 'required|string|max:6|unique:comunidad',
            'informacion_adicional' => 'nullable|string',
            'ruta_imagen' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('ruta_imagen')) {
            $validated['ruta_imagen'] = $request->file('ruta_imagen')->store('comunidades', 'public');
        }

        Comunidad::create($validated);

        return redirect()->route('comunidades.index')->with('success', 'Comunidad creada correctamente.');
    }

    public function edit($id)
    {
        $comunidad = Comunidad::findOrFail($id);
        return view('admin.comunidades.edit', compact('comunidad'));
    }

    public function update(Request $request, $id)
    {
        $comunidad = Comunidad::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'codigo' => "required|string|max:6|unique:comunidad,codigo,$id",
            'informacion_adicional' => 'nullable|string',
            'ruta_imagen' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('ruta_imagen')) {
            $validated['ruta_imagen'] = $request->file('ruta_imagen')->store('comunidades', 'public');
        }

        $comunidad->update($validated);

        return redirect()->route('comunidades.index')->with('success', 'Comunidad actualizada correctamente.');
    }

    public function destroy($id)
    {
        $comunidad = Comunidad::findOrFail($id);
        if ($comunidad->ruta_imagen && file_exists(storage_path("app/public/{$comunidad->ruta_imagen}"))) {
            unlink(storage_path("app/public/{$comunidad->ruta_imagen}"));
        }
        $comunidad->delete();

        return redirect()->route('comunidades.index')->with('success', 'Comunidad eliminada correctamente.');
    }
}
