<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LogActions;
use Illuminate\Support\Facades\DB;

class LogActionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Limpiar la tabla antes de insertar (opcional, comentar si quieres mantener datos existentes)
        // DB::table('log_actions')->truncate();

        $actions = [
            [
                'id' => 1,
                'action' => 'Login',
                'description' => 'El usuario {user} ha iniciado sesión el {dia} a las {hora}',
            ],
            [
                'id' => 2,
                'action' => 'Logout',
                'description' => 'El usuario {user} ha cerrado sesión el {dia} a las {hora}',
            ],
            [
                'id' => 3,
                'action' => 'Email Enviado',
                'description' => 'Email enviado a {user} - {referencia}',
            ],
            [
                'id' => 4,
                'action' => 'Usuario Creado',
                'description' => 'El usuario {user} ha creado un nuevo usuario el {dia} a las {hora}',
            ],
            [
                'id' => 5,
                'action' => 'Usuario Actualizado',
                'description' => 'El usuario {user} ha actualizado un usuario el {dia} a las {hora}',
            ],
            [
                'id' => 6,
                'action' => 'Usuario Eliminado',
                'description' => 'El usuario {user} ha eliminado un usuario el {dia} a las {hora}',
            ],
            [
                'id' => 7,
                'action' => 'Comunidad Creada',
                'description' => 'El usuario {user} ha creado una comunidad el {dia} a las {hora}',
            ],
            [
                'id' => 8,
                'action' => 'Comunidad Actualizada',
                'description' => 'El usuario {user} ha actualizado una comunidad el {dia} a las {hora}',
            ],
            [
                'id' => 9,
                'action' => 'Comunidad Eliminada',
                'description' => 'El usuario {user} ha eliminado una comunidad el {dia} a las {hora}',
            ],
            [
                'id' => 10,
                'action' => 'Sección Creada',
                'description' => 'El usuario {user} ha creado una sección el {dia} a las {hora}',
            ],
            [
                'id' => 11,
                'action' => 'Sección Actualizada',
                'description' => 'El usuario {user} ha actualizado una sección el {dia} a las {hora}',
            ],
            [
                'id' => 12,
                'action' => 'Sección Eliminada',
                'description' => 'El usuario {user} ha eliminado una sección el {dia} a las {hora}',
            ],
            [
                'id' => 13,
                'action' => 'Documento Subido',
                'description' => 'El usuario {user} ha subido un documento el {dia} a las {hora}',
            ],
            [
                'id' => 14,
                'action' => 'Documento Eliminado',
                'description' => 'El usuario {user} ha eliminado un documento el {dia} a las {hora}',
            ],
            [
                'id' => 15,
                'action' => 'Notificación Creada',
                'description' => 'El usuario {user} ha creado una notificación el {dia} a las {hora}',
            ],
            [
                'id' => 16,
                'action' => 'Configuración Actualizada',
                'description' => 'El usuario {user} ha actualizado una configuración el {dia} a las {hora}',
            ],
            [
                'id' => 26,
                'action' => 'Usuario Registrado',
                'description' => 'El usuario {user} se ha registrado en el sistema el {dia} a las {hora}',
            ],
        ];

        foreach ($actions as $action) {
            // Usar updateOrCreate para evitar duplicados si el ID ya existe
            LogActions::updateOrCreate(
                ['id' => $action['id']],
                [
                    'action' => $action['action'],
                    'description' => $action['description'],
                ]
            );
        }

        $this->command->info('LogActions seeder ejecutado correctamente. ' . count($actions) . ' acciones creadas/actualizadas.');
    }
}
