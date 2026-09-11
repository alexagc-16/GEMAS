<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VeterinarioStoreRequest extends FormRequest
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
        'nombre' => 'required|string|max:100',
        'apellido' => 'required|string|max:100',
        'documentoIdentidad' => 'required|string|max:20',
        'telefono' => 'required|string|max:20',
        'correo' => 'required|email|max:100',
        'especialidad' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del veterinario es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',

            'apellido.required' => 'El apellido del veterinario es obligatorio.',
            'apellido.max' => 'El apellido no puede superar los 100 caracteres.',

            'documentoIdentidad.required' => 'El documento de identidad es obligatorio.',
            'documentoIdentidad.max' => 'El documento de identidad no puede superar los 20 caracteres.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',

            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'El correo electrónico debe tener un formato válido.',
            'correo.max' => 'El correo electrónico no puede superar los 100 caracteres.',

            'especialidad.required' => 'La especialidad es obligatoria.',
            'especialidad.max' => 'La especialidad no puede superar los 100 caracteres.',
        ];
    }
}
