<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsolidacionesOfertaRequest extends FormRequest
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
			'cantidad' => 'required',
			'estado' => 'required|string',
			'id_solicitudes_compras' => 'required',
			'id_solicitud_elemento' => 'required',
			'id_consolidaciones' => 'required',
			'id_solicitudes_ofertas' => 'required',
        ];
    }
}