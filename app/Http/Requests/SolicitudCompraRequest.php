<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudCompraRequest extends FormRequest
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
			'fecha_solicitud' => 'required',
			'nombre' => 'required',
			'area' => 'required|string',
			'tipo_factura' => 'required|string',
			'prefijo' => 'required|string',
			'cantidad' => 'required|string',
			'nota' => 'required|string',
			'id_centro_costo' => 'required|string',
			'id_referencia_gastos' => 'required|string',
        ];
    }
}
