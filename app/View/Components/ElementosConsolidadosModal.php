<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ElementosConsolidadosModal extends Component
{
    public $consolidacion;
    public $modalId;
    public $elementosConsolidados;

    public function __construct($consolidacion, $modalId)
    {
        $this->consolidacion = $consolidacion;
        $this->modalId = $modalId;
        $this->elementosConsolidados = $consolidacion->elementosConsolidados;
    }

    public function render()
    {
        return view('components.elementos-consolidados-modal');
    }
}
