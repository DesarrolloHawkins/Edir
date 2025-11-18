<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\User;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(Request $request)
    {
        $query = Logs::with('user')->orderBy('date', 'desc');

        // Filtro por acción
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filtro por usuario
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filtro por fecha desde
        if ($request->filled('fecha_desde')) {
            $query->whereDate('date', '>=', $request->fecha_desde);
        }

        // Filtro por fecha hasta
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('date', '<=', $request->fecha_hasta);
        }

        // Filtro por búsqueda en descripción
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(50);

        // Obtener acciones únicas para el filtro
        $actions = Logs::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        // Obtener usuarios que tienen logs
        $users = User::whereHas('logs')->orderBy('name')->get();

        return view('admin.configuraciones.logs.index', compact('logs', 'actions', 'users'));
    }
}
