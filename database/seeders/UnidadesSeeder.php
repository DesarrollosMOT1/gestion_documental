<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

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
        ]);
    }
}