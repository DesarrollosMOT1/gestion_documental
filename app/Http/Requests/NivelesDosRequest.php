<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NivelesDosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Obtener el ID del nivel dos de la ruta
        $id = $this->route('niveles_do'); // Cambia 'niveles_do' por el nombre de tu parámetro de ruta, si es diferente

        return [
            'nombre' => [
                'required',
                'string',
                Rule::unique('niveles_dos', 'nombre')->ignore($id), // Verificar que sea único, ignorando el ID actual
            ],
            'id_niveles_uno' => 'required',
            'inventario' => 'nullable|boolean',
        ];
    }
}
