<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdenesCompraRequest extends FormRequest
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
            'fecha_emision' => 'required|date',
            'cotizaciones' => 'required|array|min:1', 
            'cotizaciones.*.id_terceros' => 'required|string',
            'cotizaciones.*.id_solicitudes_cotizaciones' => 'required|integer|exists:solicitudes_cotizaciones,id',
            'cotizaciones.*.id_consolidaciones_oferta' => 'required|integer|exists:consolidaciones_ofertas,id',
            'cotizaciones.*.id_solicitud_elemento' => 'required|integer|exists:solicitudes_elementos,id',
            'cotizaciones.*.id_cotizaciones_precio' => 'required|integer|exists:cotizaciones_precio,id',
        ];
    }
}
