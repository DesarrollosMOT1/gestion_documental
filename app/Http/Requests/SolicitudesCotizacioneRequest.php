<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudesCotizacioneRequest extends FormRequest
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
			'id_solicitudes_compras' => 'required',
			'id_cotizaciones' => 'required',
			'cantidad' => 'required',
			'id_impuestos' => 'required',
            'precio' => 'required',
			'estado' => 'required|string',
        ];
    }
}
