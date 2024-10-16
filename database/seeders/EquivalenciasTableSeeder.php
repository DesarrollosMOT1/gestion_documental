<?php

namespace Database\Seeders;

use App\Models\Equivalencia;
use App\Models\Unidades;
use Illuminate\Database\Seeder;

class EquivalenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidad1 = Unidades::where('nombre', 'Unidad 1')->first();
        $unidad2 = Unidades::where('nombre', 'Unidad 2')->first();
        $unidad3 = Unidades::where('nombre', 'Unidad 3')->first();

        Equivalencia::create([
            'unidad_principal' => $unidad2->id,
            'unidad_equivalente' => $unidad1->id,
            'cantidad' => 2,
        ]);

        Equivalencia::create([
            'unidad_principal' => $unidad3->id,
            'unidad_equivalente' => $unidad2->id,
            'cantidad' => 3,
        ]);
    }
}
