<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Lista de áreas a crear
        $areas = [
            ['nombre' => 'Administrativa'],
            ['nombre' => 'Financiera'],
            ['nombre' => 'Comercial'],
            ['nombre' => 'Gerencial'],
            ['nombre' => 'Operaciones'],
            ['nombre' => 'Sistemas'],
            ['nombre' => 'Talento Humano'],
            ['nombre' => 'Seguridad y Salud'],
        ];

        // Crear las áreas si no existen
        foreach ($areas as $area) {
            Area::firstOrCreate(['nombre' => $area['nombre']]);
        }
    }
}
