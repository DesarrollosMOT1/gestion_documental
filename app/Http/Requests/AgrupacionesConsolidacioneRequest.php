<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgrupacionesConsolidacioneRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'fecha_consolidacion' => 'required|date',
            'elementos' => 'required|array|min:1',
            'elementos.*.id_solicitud_elemento' => 'required|exists:solicitudes_elementos,id',
            'elementos.*.id_solicitudes_compra' => 'required|exists:solicitudes_compras,id',
            'elementos.*.cantidad' => 'required|numeric|min:1',
            'elementos.*.elementos_originales' => 'sometimes|array',
            'elementos.*.elementos_originales.*.id_solicitud_elemento' => 'required|exists:solicitudes_elementos,id',
            'elementos.*.elementos_originales.*.id_solicitudes_compra' => 'required|exists:solicitudes_compras,id',
            'elementos.*.elementos_originales.*.cantidad' => 'required|numeric|min:1',
        ];
    }
}
