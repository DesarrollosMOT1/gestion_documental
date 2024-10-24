<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TerceroRequest extends FormRequest
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
        // Obtener el ID del tercero desde la ruta
        $id = $this->route('tercero');

        return [
            'nit' => [
                'required',
                'string',
                Rule::unique('terceros', 'nit')->ignore($id),
            ],
            'nombre' => [
                'required',
                'string',
                Rule::unique('terceros', 'nombre')->ignore($id),
            ],
            'tipo_factura' => 'required|string',
        ];
    }
}
