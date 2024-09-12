<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposYClasesMovimientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Entrada', 'descripcion' => 'Movimiento de entrada'],
            ['nombre' => 'Salida', 'descripcion' => 'Movimiento de salida'],
            ['nombre' => 'Proceso', 'descripcion' => 'Movimiento de proceso'],
        ];

        foreach ($tipos as $tipo) {
            DB::table('tipos_movimientos')->insert($tipo);
        }

        $entradaId = DB::table('tipos_movimientos')->where('nombre', 'Entrada')->first()->id;
        $salidaId = DB::table('tipos_movimientos')->where('nombre', 'Salida')->first()->id;
        $procesoId = DB::table('tipos_movimientos')->where('nombre', 'Proceso')->first()->id;

        $clases = [
            #entrada
            ['nombre' => 'estandar', 'descripcion' => 'Entrada de productos al inventario', 'tipo' => $entradaId],
            ['nombre' => 'sin marcar', 'descripcion' => 'Entrada de productos específicos', 'tipo' => $entradaId],
            ['nombre' => 'averia', 'descripcion' => 'Entrada de productos al inventario', 'tipo' => $entradaId],
            ['nombre' => 'faltante', 'descripcion' => 'Entrada de productos al inventario', 'tipo' => $entradaId],
            ['nombre' => 'sobrante', 'descripcion' => 'Entrada de productos específicos', 'tipo' => $entradaId],
            #salida
            ['nombre' => 'transporte', 'descripcion' => 'Salida de productos del inventario', 'tipo' => $salidaId],
            ['nombre' => 'daño', 'descripcion' => 'Salida de productos específicos', 'tipo' => $salidaId],
            #proceso
            ['nombre' => 'traspaso de codigo', 'descripcion' => 'Proceso de producción de productos', 'tipo' => $procesoId],
            ['nombre' => 'traspaso de unidad de medida', 'descripcion' => 'Proceso de producción de productos', 'tipo' => $procesoId],
            ['nombre' => 'traslado', 'descripcion' => 'Proceso de producción de productos', 'tipo' => $procesoId],
            ['nombre' => 'almacenamiento', 'descripcion' => 'Proceso de producción de productos', 'tipo' => $procesoId],
            ['nombre' => 'reporte de averia', 'descripcion' => 'Proceso de producción de productos', 'tipo' => $procesoId],
            ['nombre' => 'reporte de faltante', 'descripcion' => 'Proceso de producción de productos', 'tipo' => $procesoId],
            ['nombre' => 'reporte de sobrante', 'descripcion' => 'Proceso de producción de productos', 'tipo' => $procesoId],
            ['nombre' => 'reporte de daño', 'descripcion' => 'Proceso de producción de productos', 'tipo' => $procesoId],
            ['nombre' => 'reporte de vencimiento', 'descripcion' => 'Proceso de producción de productos', 'tipo' => $procesoId],

        ];

        foreach ($clases as $clase) {
            DB::table('clases_movimientos')->insert($clase);
        }
    }
}
