<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsolidacioneRequest extends FormRequest
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
            'elementos.*.id_solicitudes_compras' => 'required|integer',
            'elementos.*.agrupacion_id' => 'required|integer',
            'elementos.*.id_solicitud_elemento' => 'required|integer',
            'elementos.*.cantidad' => 'required|integer|min:1',
        ];
    }
}
