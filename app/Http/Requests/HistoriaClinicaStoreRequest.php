<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'antecedentes' => 'required|string',
            'alergias' => 'required|string',
            'enfermedadesPrevias' => 'required|string',
            'observaciones' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'antecedentes.required' => 'Los antecedentes son obligatorios.',

            'alergias.required' => 'Las alergias son obligatorias.',

            'enfermedadesPrevias.required' => 'Las enfermedades previas son obligatorias.',

            'observaciones.required' => 'Las observaciones son obligatorias.',
        ];
    }
}
