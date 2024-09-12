<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotivosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('motivos')->insert([
            [
                'nombre' => 'Motivo 1',
                'descripcion' => 'Descripción del motivo 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Motivo 2',
                'descripcion' => 'Descripción del motivo 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
