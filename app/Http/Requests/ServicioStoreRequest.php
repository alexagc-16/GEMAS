<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ServicioStoreRequest extends FormRequest
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
            'descripcion' => 'required|string|max:255',
            'duracionMinutos' => 'required|integer|min:1|max:240',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'nombre.max' => 'El nombre del servicio no puede superar los 100 caracteres.',

            'descripcion.required' => 'La descripción del servicio es obligatoria.',
            'descripcion.max' => 'La descripción del servicio no puede superar los 255 caracteres.',

            'duracionMinutos.required' => 'La duración del servicio es obligatoria.',
            'duracionMinutos.integer' => 'La duración debe ser un número entero.',
            'duracionMinutos.min' => 'La duración debe ser de al menos 1 minuto.',
            'duracionMinutos.max' => 'La duración no puede superar las 4 horas (240 minutos).',
        ];
    }
}
