<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EvolucionStoreRequest extends FormRequest
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
            'fecha' => 'required|date',
            'peso' => 'required|numeric',
            'temperatura' => 'required|numeric',
            'sintomas' => 'required|string',
            'observaciones' => 'required|string',
            'idHistoriaClinica' => 'required|exists:historiaClinica,id',
            'idVeterinario' => 'required|exists:veterinario,id',
        ];
    }

    public function messages(): array
    {
        return [
            'fecha.required' => 'La fecha de la evolución es obligatoria.',

            'peso.required' => 'El peso es obligatorio.',

            'temperatura.required' => 'La temperatura es obligatoria.',

            'sintomas.required' => 'Los síntomas son obligatorios.',

            'observaciones.required' => 'Las observaciones son obligatorias.',

            'idHistoriaClinica.required' => 'La historia clínica es obligatoria.',
            'idHistoriaClinica.exists' => 'La historia clínica seleccionada no existe.',

            'idVeterinario.required' => 'El veterinario es obligatorio.',
            'idVeterinario.exists' => 'El veterinario seleccionado no existe.',
        ];
    }
}
