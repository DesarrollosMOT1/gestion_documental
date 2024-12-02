<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NivelesTresRequest extends FormRequest
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
        $id = $this->route('niveles_tre');

        return [
            'nombre' => [
                'required',
                'string',
                Rule::unique('niveles_tres', 'nombre')->ignore($id),
            ],
            'id_niveles_dos' => 'required|exists:niveles_dos,id',
            'id_referencias_gastos' => 'required|exists:referencias_gastos,id',
            'inventario' => 'nullable|boolean',
            'unidad_id' => 'nullable|exists:unidades,id',
        ];
    }
}
