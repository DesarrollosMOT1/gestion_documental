<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionesPrecioRequest extends FormRequest
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
            'id_solicitudes_cotizaciones' => 'required|integer|exists:solicitudes_cotizaciones,id', // Debe existir en la tabla 'solicitudes_cotizaciones'
            'id_agrupaciones_consolidaciones' => 'required|integer|exists:agrupaciones_consolidaciones,id', // Debe existir en la tabla 'agrupaciones_consolidaciones'
            'descripcion' => 'nullable|string', // Puede ser opcional
            'estado' => 'nullable|boolean', // Se puede omitir o ser verdadero/falso
            'estado_jefe' => 'nullable|boolean', // Se puede omitir o ser verdadero/falso
            'justificacion_jefe' => 'nullable|string',
        ];
    }
}
