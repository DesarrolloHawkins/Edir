<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    public function index()
    {
        $mantenimientos = Mantenimiento::all();
        return view('admin.configuraciones.mantenimiento.index', compact('mantenimientos'));
    }

    public function create()
    {
        return view('admin.configuraciones.mantenimiento.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'numero' => 'required',
            'dias' => 'array',
            'horas' => 'array',
        ]);

        $disponibilidad = [];
        if ($request->has('dias')) {
            foreach ($request->dias as $dia) {
                $inicio = $request->horas[$dia]['inicio'] ?? null;
                $fin = $request->horas[$dia]['fin'] ?? null;
                if ($inicio && $fin) {
                    $disponibilidad[$dia][] = ['inicio' => $inicio, 'fin' => $fin];
                }
            }
        }

        Mantenimiento::create([
            'nombre' => $request->nombre,
            'empresa' => $request->empresa,
            'numero' => $request->numero,
            'otros_cambios' => $request->otros_cambios,
            'disponibilidad' => $disponibilidad,
        ]);

        return redirect()->route('config.mantenimiento.index')->with('success', 'Mantenimiento creado.');
    }


    public function edit(Mantenimiento $mantenimiento)
    {
        return view('admin.configuraciones.mantenimiento.edit', compact('mantenimiento'));
    }

    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        $request->validate([
            'nombre' => 'required',
            'numero' => 'required',
            'dias' => 'array',
            'horas' => 'array',
        ]);
    
        $disponibilidad = [];
        if ($request->has('dias')) {
            foreach ($request->dias as $dia) {
                $inicio = $request->horas[$dia]['inicio'] ?? null;
                $fin = $request->horas[$dia]['fin'] ?? null;
                if ($inicio && $fin) {
                    $disponibilidad[$dia][] = ['inicio' => $inicio, 'fin' => $fin];
                }
            }
        }
    
        $mantenimiento->update([
            'nombre' => $request->nombre,
            'empresa' => $request->empresa,
            'numero' => $request->numero,
            'otros_cambios' => $request->otros_cambios,
            'disponibilidad' => $disponibilidad,
        ]);
    
        return redirect()->route('config.mantenimiento.index')->with('success', 'Actualizado correctamente.');
    }
    public function destroy(Mantenimiento $mantenimiento)
    {
        $mantenimiento->delete();
        return back()->with('success', 'Eliminado correctamente.');
    }
}
