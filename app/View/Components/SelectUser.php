<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SelectUser extends Component
{
    public $nombre;
    public $valor;
    public $errores;

    public function __construct($nombre, $valor = null, $errores = null)
    {
        $this->nombre = $nombre;
        $this->valor = $valor ?? Auth::user()->id; // Usuario autenticado por defecto
        $this->errores = $errores;
    }

    public function render()
    {
        return view('components.select-user');
    }
}
