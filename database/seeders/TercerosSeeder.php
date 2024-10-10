<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TercerosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('terceros')->insert([
            [
                'nit' => '123456789',
                'tipo_factura' => 'Venta',
                'nombre' => 'Comercial XYZ S.A.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nit' => '987654321',
                'tipo_factura' => 'Compra',
                'nombre' => 'Importaciones ABC Ltda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nit' => '1122334455',
                'tipo_factura' => 'Venta',
                'nombre' => 'Distribuidora DEF S.A.S.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
