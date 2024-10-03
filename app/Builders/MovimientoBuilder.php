<?php

use App\Models\Movimiento;
use Illuminate\Support\Facades\Http;

class MovimientoBuilder
{
    protected $movimientoData;

    protected $registrosArray = [];

    protected $trasladosArray = [];

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

    // Método final para construir el movimiento, registros y traslados
    public function build()
    {
        // Crear el movimiento
        $movimiento = $this->storeMovimiento($this->movimientoData);

        // Agregar los registros al movimiento
        if (! empty($this->registrosArray)) {
            $this->storeRegistros($movimiento->id, $this->registrosArray);
        }

        return $movimiento;
    }

    // Lógica para almacenar el movimiento
    protected function storeMovimiento(array $movimientoData)
    {
        return Movimiento::create($movimientoData);  // Simulación de guardado
    }

    // Lógica para almacenar los registros
    protected function storeRegistros(int $movimientoId, array $registrosArray): void
    {
        Http::post(route('registros.store-array', ['movimientoId' => $movimientoId]), $registrosArray);
    }
}
