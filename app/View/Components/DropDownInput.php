<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropDownInput extends Component
{
    public $route;
    public $name;
    public $placeholder;

    public function __construct($route, $name, $placeholder = 'Escribe para buscar...')
    {
        $this->route = $route;
        $this->name = $name;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.drop-down-input');
    }
}
