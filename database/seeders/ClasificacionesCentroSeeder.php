<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClasificacionesCentro;

class ClasificacionesCentroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $clasificaciones = [
            ['nombre' => 'ADMINISTRATIVOS MANIZALES'],
            ['nombre' => 'BODEGA MANIZALES'],
            ['nombre' => 'BODEGAS'],
            ['nombre' => 'COMERCIAL MANIZALES'],
            ['nombre' => 'GENERAL VEHICULO'],
            ['nombre' => 'GERENCIAL'],
            ['nombre' => 'INNOVACION Y TECNOLOGIA'],
            ['nombre' => 'SEDE BARRANQUILLA'],
            ['nombre' => 'SEDE BOGOTA'],
            ['nombre' => 'SEDE BUENAVENTURA'],
            ['nombre' => 'SEDE CALI'],
            ['nombre' => 'SEDE CARTAGENA'],
            ['nombre' => 'SEDE MEDELLIN'],
            ['nombre' => 'VEHICULO'],
            ['nombre' => 'VEHICULO TERCERO'],
        ];

        foreach ($clasificaciones as $clasificacion) {
            ClasificacionesCentro::updateOrCreate(
                ['nombre' => $clasificacion['nombre']], // Condición de búsqueda
                $clasificacion // Valores a insertar o actualizar
            );
        }
    }
}
