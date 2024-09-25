<?php

namespace App\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public $modalTitle;
    public $modalContent;
    public $modalSize; // Nueva propiedad para el tamaño

    public function mount($title = 'Modal Título', $content = '', $size = 'modal-md') // Valor por defecto
    {
        $this->modalTitle = $title;
        $this->modalContent = $content;
        $this->modalSize = $size; // Asignar el tamaño
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
