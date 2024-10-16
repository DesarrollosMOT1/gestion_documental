<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unidades')->insert([
            [
                'nombre' => 'Unidad 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Unidad 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Unidad 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
