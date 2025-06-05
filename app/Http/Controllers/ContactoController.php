<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index()
    {
        $contacto = Contacto::first();
        return view('admin.contacto.index', compact('contacto'));
    }

    public function edit()
    {
        $contacto = Contacto::first();
        return view('admin.contacto.edit', compact('contacto'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nombre_empresa' => 'nullable|string',
            'cif' => 'nullable|string',
            'domicilio' => 'nullable|string',
            'ciudad' => 'nullable|string',
            'provincia' => 'nullable|string',
            'codigo_postal' => 'nullable|string',
            'telefono' => 'nullable|string',
            'maps' => 'nullable|string',
        ]);

        $contacto = Contacto::firstOrCreate([]);
        $contacto->update($data);

        return redirect()->route('home')->with('success', 'Datos actualizados correctamente.');
    }
    public function form()
    {
        $contacto = Contacto::first();
        return view('contacto.form', compact('contacto'));
    }
}
