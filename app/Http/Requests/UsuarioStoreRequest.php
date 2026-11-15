<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $esCreacion = $this->isMethod('post');

        return [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'documentoIdentidad' => 'required|string|max:15',
            'telefono' => 'required|string|max:15',
            'email' => [
                'required',
                'string',
                'email',
                'max:50', 
                Rule::unique('usuario', 'email')->ignore($this->route('id')),
            ],
            'direccion' => 'nullable|string|max:50',
            'password' => [
                $esCreacion ? 'required' : 'nullable',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/',
                'confirmed',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 50 caracteres.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede superar los 50 caracteres.',

            'documentoIdentidad.required' => 'El documento de identidad es obligatorio.',
            'documentoIdentidad.max' => 'El documento de identidad no puede superar los 15 caracteres.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.max' => 'El teléfono no puede superar los 15 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.max' => 'El correo electrónico no puede superar los 50 caracteres.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado.',

            'direccion.string' => 'La dirección debe ser un texto válido.',
            'direccion.max' => 'La dirección no puede superar los 255 caracteres.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir al menos una mayúscula, una minúscula, un número y un carácter especial.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
