<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TercerosTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tercerosTest')->insert([
            [
                'nombre' => 'Tercero 1',
                'correo' => 'tercero1@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Tercero 2',
                'correo' => 'tercero2@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
