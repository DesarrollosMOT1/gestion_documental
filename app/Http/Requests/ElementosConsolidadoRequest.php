<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ElementosConsolidadoRequest extends FormRequest
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
			'id_consolidacion' => 'required',
			'id_solicitud_compra' => 'required',
			'id_solicitud_elemento' => 'required',
        ];
    }
}
