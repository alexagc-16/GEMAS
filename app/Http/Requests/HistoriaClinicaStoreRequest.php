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
            'antecedentes' => 'required|string',
            'alergias' => 'required|string',
            'enfermedadesPrevias' => 'required|string',
            'observaciones' => 'required|string',
            'idMascota' => 'required|exists:mascota,id',
        ];
    }

    public function messages(): array
    {
        return [
            'fechaApertura.required' => 'La fecha de apertura es obligatoria.',
            'fechaApertura.date' => 'La fecha de apertura debe tener un formato válido.',

            'antecedentes.required' => 'Los antecedentes son obligatorios.',

            'alergias.required' => 'Las alergias son obligatorias.',

            'enfermedadesPrevias.required' => 'Las enfermedades previas son obligatorias.',

            'observaciones.required' => 'Las observaciones son obligatorias.',

            'idMascota.required' => 'La mascota es obligatoria.',
            'idMascota.exists' => 'La mascota seleccionada no existe.',
        ];
    }
}
