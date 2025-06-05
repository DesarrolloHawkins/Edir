<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comunidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function index(Request $request)
{
    // Obtener filtros
    $perPage = $request->get('per_page', 10);
    $comunidadId = $request->get('comunidad_id');
    $search = $request->get('search');

    // Query base
    $query = User::query();

    // Filtro por comunidad
    if ($comunidadId) {
        $query->where('comunidad_id', $comunidadId);
    }

    // Filtro por búsqueda
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('username', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%")
              ->orWhere('surname', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Obtener resultados paginados
    $usuarios = $query->orderBy('id', 'desc')->paginate($perPage);

    // Obtener comunidades para el filtro
    $comunidades = Comunidad::all();

    return view('admin.usuarios.index', compact('usuarios', 'comunidades', 'perPage', 'comunidadId', 'search'));
}


    public function create()
    {
        $comunidades = Comunidad::all();
        return view('admin.usuarios.create', compact('comunidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'telefono' => 'nullable|string|max:15',
            'role' => 'required|string|max:50',
            'comunidad_id' => 'nullable|exists:comunidades,id',
        ]);

        $validated['password'] = Hash::make($request->password);

        User::create($validated);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $comunidades = Comunidad::all();
        return view('admin.usuarios.edit', compact('usuario', 'comunidades'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $validated = $request->validate([
            'username' => "required|string|max:255|unique:users,username,{$id}",
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'password' => 'nullable|string|min:6|confirmed',
            'telefono' => 'nullable|string|max:15',
            'role' => 'required|string|max:50',
            'comunidad_id' => 'nullable|exists:comunidades,id',
        ]);

        if ($request->password) {
            $validated['password'] = Hash::make($request->password);
        }

        $usuario->update($validated);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
