<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HistoriaClinicaStoreRequest extends FormRequest
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
            'fechaApertura' => 'required|date',
            'antecedentes' => 'required|string|max:255',
            'alergias' => 'required|string|max:255',
            'enfermedadesPrevias' => 'required|string|max:255',
            'observaciones' => 'required|string|max:255',
            'idMascota' => 'required|exists:mascota,id',
        ];
    }

    public function messages(): array
    {
        return [
            'fechaApertura.required' => 'La fecha de apertura es obligatoria.',
            'fechaApertura.date' => 'La fecha de apertura debe tener un formato válido.',

            'antecedentes.required' => 'Los antecedentes son obligatorios.',
            'antecedentes.max' => 'Los antecedentes no pueden superar los 255 caracteres.',

            'alergias.required' => 'Las alergias son obligatorias.',
            'alergias.max' => 'Las alergias no pueden superar los 255 caracteres.',

            'enfermedadesPrevias.required' => 'Las enfermedades previas son obligatorias.',
            'enfermedadesPrevias.max' => 'Las enfermedades previas no pueden superar los 255 caracteres.',

            'observaciones.required' => 'Las observaciones son obligatorias.',
            'observaciones.max' => 'Las observaciones no pueden superar los 255 caracteres.',

            'idMascota.required' => 'La mascota es obligatoria.',
            'idMascota.exists' => 'La mascota seleccionada no existe.',
        ];
    }
}
