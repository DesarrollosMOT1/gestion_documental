<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BodegasYAlmacenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bodega1 = DB::table('bodegas')->insertGetId([
            'nombre' => 'Bodega Central',
            'direccion' => 'Avenida Principal 123',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $bodega2 = DB::table('bodegas')->insertGetId([
            'nombre' => 'Bodega Secundaria',
            'direccion' => 'Calle Secundaria 456',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear almacenes relacionados a las bodegas
        DB::table('almacenes')->insert([
            [
                'bodega' => $bodega1,
                'nombre' => 'Almacén A1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bodega' => $bodega1,
                'nombre' => 'Almacén A2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bodega' => $bodega2,
                'nombre' => 'Almacén B1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bodega' => $bodega2,
                'nombre' => 'Almacén B2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
