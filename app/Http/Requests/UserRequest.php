<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . ($this->user ? $this->user->id : 'NULL'),
            'password' => 'nullable|string|min:8|confirmed',
            'id_area' => 'required|exists:areas,id',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ];

        // Si estamos en la creación de un nuevo usuario, la contraseña es obligatoria.
        if (!$this->user) {
            $rules['password'] .= '|required';
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Se asegura de que el campo 'user' no sea nulo en el contexto de actualización.
        if ($this->user()) {
            $this->merge([
                'user' => $this->user(),
            ]);
        }
    }
}
