<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            [
                'codigo_producto' => strval(mt_rand(1000000000000, 9999999999999)), // Genera un número de 13 cifras
                'nombre' => 'Producto 1',
                'unidad_medida_peso' => 'kg',
                'peso_bruto' => 100,
                'medida_volumen' => 50,
                'ean' => 12345678,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo_producto' => strval(mt_rand(1000000000000, 9999999999999)), // Genera un número de 13 cifras
                'nombre' => 'Producto 2',
                'unidad_medida_peso' => 'g',
                'peso_bruto' => 200,
                'medida_volumen' => 75,
                'ean' => 123456124,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
