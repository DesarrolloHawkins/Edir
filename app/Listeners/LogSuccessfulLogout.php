<?php

namespace App\Listeners;

use App\Models\LogActions;
use App\Models\Logs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $fecha = Carbon::now();
        $logAction = LogActions::where('id', 2)->first();
        
        // Verificar si existe el registro antes de acceder a sus propiedades
        if (!$logAction) {
            // Si no existe, usar valores por defecto
            $action = 'Logout';
            $descripcion_base = 'El usuario {user} ha cerrado sesión el {dia} a las {hora}';
        } else {
            $action = $logAction->action;
            $descripcion_base = $logAction->description;
        }
        
        $user = User::find($event->user->id);
        $userName = $user ? $user->name : 'Usuario desconocido';
        
        $descripcion = str_replace('{user}', $userName, $descripcion_base);
        $descripcion = str_replace('{hora}', substr($fecha, 10, 9), $descripcion);
        $descripcion = str_replace('{dia}', substr($fecha, 0, 10), $descripcion);

        Logs::create([
            'user_id' => $event->user->id,
            'action' => $action,
            'description' => $descripcion,
            'date' => $fecha,
        ]);
    }
}
