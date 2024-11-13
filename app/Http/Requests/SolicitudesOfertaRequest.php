<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudesOfertaRequest extends FormRequest
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
            'fecha_solicitud_oferta' => 'required|date', // Asegurar que sea una fecha válida
            'id_users' => 'required|exists:users,id', // Validar que el usuario exista
            'terceros' => ['required', 'array'],  
            'terceros.*' => ['exists:terceros,id'], 
            'elementos' => 'required|array|min:1',
            'elementos.*.id_solicitudes_compras' => 'required|exists:solicitudes_compras,id', // Validar que cada id_solicitudes_compras exista
            'elementos.*.id_solicitud_elemento' => 'required|exists:solicitudes_elementos,id', // Validar que cada id_solicitud_elemento exista
            'elementos.*.id_consolidaciones' => 'required|exists:consolidaciones,id', // Validar que cada id_consolidaciones exista
            'elementos.*.descripcion' => 'nullable|string|max:255',
        ];
    }
}
