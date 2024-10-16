<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CentrosCostoRequest extends FormRequest
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
        $id = $this->route('centros_costo');

        return [
            'codigo_mekano' => [
                'required',
                'string',
                Rule::unique('centros_costos', 'codigo_mekano')->ignore($id), // Verificar que sea único, ignorando el ID actual
            ],
            'nombre' => [
                'required',
                'string',
                Rule::unique('centros_costos', 'nombre')->ignore($id), // Verificar que sea único, ignorando el ID actual
            ],
            'id_clasificaciones_centros' => 'required',
        ];
    }
}
