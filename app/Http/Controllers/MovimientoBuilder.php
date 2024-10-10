<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Registro;

class MovimientoBuilder extends Controller
{
    protected $movimientoData;

    protected $registrosArray = [];

    // Método para establecer los datos del movimiento
    public function setMovimientoData(array $data): self
    {
        $this->movimientoData = $data;

        return $this;
    }

    // Método para agregar un registro individual
    public function addRegistro(array $registro): self
    {
        $this->registrosArray[] = $registro;

        return $this;
    }

    // Método para agregar múltiples registros
    public function addRegistros(array $registros): self
    {
        foreach ($registros as $registro) {
            $this->addRegistro($registro);
        }

        return $this;
    }

    // Método final para construir el movimiento y los registros
    public function build()
    {

        $movimiento = $this->storeMovimiento($this->movimientoData);

        if (! empty($this->registrosArray)) {
            foreach ($this->registrosArray as &$registro) {
                $registro['movimiento'] = $movimiento->id;
            }
            $this->storeRegistros($this->registrosArray);
        }

        return $movimiento;
    }

    // Lógica para almacenar el movimiento
    protected function storeMovimiento(array $movimientoData)
    {
        return Movimiento::create($movimientoData);
    }

    // Lógica para almacenar los registros
    protected function storeRegistros(array $registrosArray): void
    {
        Registro::insert($registrosArray);
    }
}
