<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadeRequest extends FormRequest
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
            'nombre' => 'required|unique:unidades|string|max:255',
            'unidad' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value !== 'base' && ! \App\Models\Unidades::where('id', $value)->exists()) {
                        $fail('La unidad seleccionada no es válida.');
                    }
                },
            ],
            'cantidad' => 'required|integer|min:1|max:1000',
        ];
    }
}
