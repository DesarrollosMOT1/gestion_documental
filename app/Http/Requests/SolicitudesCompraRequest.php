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
            'elements' => 'required|array|min:1', // Asegúrate de que haya al menos un elemento
            'elements.*.id_niveles_tres' => 'required|exists:niveles_tres,id', // Validación para id_niveles_tres
            'elements.*.id_centros_costos' => 'required|exists:centros_costos,id', // Validación para id_centros_costos
            'elements.*.cantidad' => 'required|integer|min:1', // Validación para cantidad
        ];
    }    
}
