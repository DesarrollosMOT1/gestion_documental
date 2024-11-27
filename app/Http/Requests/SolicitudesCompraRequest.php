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
            'fecha_solicitud' => 'required|date',
            'id_users' => 'required|exists:users,id',
            'prefijo' => 'required|string',
            'descripcion' => 'required|string|max:255',
            'elements' => 'required|array|min:1', // Asegúrate de que haya al menos un elemento
            'elements.*.id_niveles_tres' => 'required|exists:niveles_tres,id', // Validación para id_niveles_tres
            'elements.*.id_centros_costos' => 'required|exists:centros_costos,id', // Validación para id_centros_costos
            'elements.*.cantidad' => 'required|integer|min:1|max:1000', // Validación para cantidad
            'elements.*.descripcion' => 'nullable|string|max:255', // Validación para descripción
        ];
    }    
}
