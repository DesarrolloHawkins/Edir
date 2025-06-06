<?php

// app/Http/Controllers/AvisoWhatsappController.php

namespace App\Http\Controllers;

use App\Models\AvisoWhatsapp;
use Illuminate\Http\Request;

class AvisoWhatsappController extends Controller
{
    public function index()
    {
        $avisos = AvisoWhatsapp::all();
        return view('admin.configuraciones.avisos.index', compact('avisos'));
    }

    public function create()
    {
        return view('admin.configuraciones.avisos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero' => 'required|string|max:20',
            'idioma' => 'required|string|max:5',
        ]);

        AvisoWhatsapp::create($request->all());

        return redirect()->route('config.avisos-whatsapp.index')->with('success', 'Aviso creado correctamente.');
    }

    public function edit(AvisoWhatsapp $aviso)
    {
        return view('admin.configuraciones.avisos.edit', compact('aviso'));
    }

    public function update(Request $request, AvisoWhatsapp $aviso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero' => 'required|string|max:20',
            'idioma' => 'required|string|max:5',
        ]);

        $aviso->update($request->all());

        return redirect()->route('config.avisos-whatsapp.index')->with('success', 'Aviso actualizado correctamente.');
    }

    public function destroy(AvisoWhatsapp $aviso)
    {
        $aviso->delete();

        return redirect()->route('config.avisos-whatsapp.index')->with('success', 'Aviso eliminado.');
    }
}
