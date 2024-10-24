<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Carbon\Carbon;

class CampoFecha extends Component
{
    public $fechaActual;
    public $nombre;
    public $valor;
    public $errores;

    public function __construct($nombre, $valor = null, $errores = null)
    {
        $this->fechaActual = Carbon::now()->toDateString();
        $this->nombre = $nombre;
        $this->valor = $valor ?? $this->fechaActual;
        $this->errores = $errores;
    }

    public function render()
    {
        return view('components.campo-fecha');
    }
}
