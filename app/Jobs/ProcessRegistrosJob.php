<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class ProcessRegistrosJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $movimientoId;

    protected $registrosArray;

    public function __construct($movimientoId, $registrosArray)
    {
        $this->movimientoId = $movimientoId;
        $this->registrosArray = $registrosArray;
    }

    public function handle()
    {
        $registrosData = $this->registrosArray;

        foreach ($registrosData as &$value) {
            $value['movimiento'] = $this->movimientoId;
        }

        DB::table('registros')->insert($registrosData);

    }
}
