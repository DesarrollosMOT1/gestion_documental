<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReferenciasGastoRequest extends FormRequest
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
        $id = $this->route('referencias_gasto');

        return [
            'codigo_mekano' => [
                'required',
                'string',
                Rule::unique('referencias_gastos', 'codigo_mekano')->ignore($id), 
            ],
            'nombre' => [
                'required',
                'string',
                Rule::unique('referencias_gastos', 'nombre')->ignore($id), 
            ],
        ];
    }
}
