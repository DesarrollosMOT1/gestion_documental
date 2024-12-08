<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacioneRequest extends FormRequest
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
			'fecha_cotizacion' => 'required',
			'nombre' => 'required|string',
			'valor' => 'required',
			'condiciones_pago' => 'required|string',
			'id_terceros' => 'required|string',
            'fecha_inicio_vigencia' => 'required',
            'fecha_fin_vigencia' => 'required',
            'id_users' => 'required|exists:users,id',
            'elementos' => 'required|array',
            'elementos.*.descuento' => 'nullable|numeric',
            'elementos.*.id_impuestos' => 'required|numeric',
            'elementos.*.precio' => 'required|numeric',
        ];
    }
}
