<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
        return [
			'codigo_producto' => 'required|string',
			'nombre' => 'required|string',
			'unidad_medida_peso' => 'required|string',
			'peso_bruto' => 'required',
			'medida_volumen' => 'required',
			'ean' => 'required',
        ];
    }
}
