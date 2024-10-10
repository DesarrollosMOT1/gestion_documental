<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EquivalenciaAddModal extends Component
{
    public $idUnidadPrincipal;

    /**
     * Create a new component instance.
     */
    public function __construct($idUnidadPrincipal)
    {
        $this->idUnidadPrincipal = $idUnidadPrincipal;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.equivalencia-add-modal');
    }
}
