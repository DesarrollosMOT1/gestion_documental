<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudesCompraRequest extends FormRequest
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
			'id_users' => 'required',
			'prefijo' => 'required|string',
			'descripcion' => 'required|string',
			'estado_solicitud' => 'required|string',
			'fecha_estado' => 'required',
        ];
    }
}