<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'documentoIdentidad' => 'required|string|max:15',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|string|max:50',
            'direccion' => 'required|string|max:50',
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

            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.max' => 'El correo electrónico no puede superar los 50 caracteres.',
            'correo.email' => 'El correo electrónico debe tener un formato válido.',

            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede superar los 50 caracteres.',
        ];
    }
}
