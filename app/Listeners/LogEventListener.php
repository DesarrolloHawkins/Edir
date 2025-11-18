<?php

namespace App\Listeners;

use App\Events\LogEvent;
use App\Models\LogActions;
use App\Models\Logs;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogEventListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(LogEvent $event)
    {
        $logAction = LogActions::where('id', $event->action_id)->first();
        
        // Verificar si existe el registro antes de acceder a sus propiedades
        if (!$logAction) {
            // Si no existe, usar valores por defecto
            $action = 'Acción Desconocida';
            $descripcion_base = 'El usuario {user} realizó una acción el {dia} a las {hora}';
        } else {
            $action = $logAction->action;
            $descripcion_base = $logAction->description;
        }
        
        $user = User::find($event->user->id);
        $userName = $user ? $user->name : 'Usuario desconocido';
        
        $descripcion = str_replace('{user}', $userName, $descripcion_base);
        $descripcion = str_replace('{hora}', substr($event->fecha, 10, 9), $descripcion);
        $descripcion = str_replace('{referencia}', $event->reference ?? '', $descripcion);
        $descripcion = str_replace('{dia}', substr($event->fecha, 0, 10), $descripcion);

        Logs::create([
            'user_id' => $event->user->id,
            'action' => $action,
            'description' => $descripcion,
            'date' => $event->fecha,
            'reference' => $event->reference
        ]);
    }
}
