<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstadoIncidencia;

class EstadoIncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [
            [
                'id' => 1,
                'nombre' => 'Pendiente',
            ],
            [
                'id' => 2,
                'nombre' => 'Procesando',
            ],
            [
                'id' => 3,
                'nombre' => 'Finalizada',
            ],
            [
                'id' => 4,
                'nombre' => 'No procede',
            ],
            [
                'id' => 5,
                'nombre' => 'Cancelada',
            ],
        ];

        foreach ($estados as $estado) {
            // Usar updateOrCreate para evitar duplicados si el ID ya existe
            EstadoIncidencia::updateOrCreate(
                ['id' => $estado['id']],
                [
                    'nombre' => $estado['nombre'],
                ]
            );
        }

        $this->command->info('EstadoIncidencia seeder ejecutado correctamente. ' . count($estados) . ' estados creados/actualizados.');
    }
}
