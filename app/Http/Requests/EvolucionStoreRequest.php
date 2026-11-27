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
            'peso' => 'required|numeric|gt:0',
            'temperatura' => 'required|numeric|gt:0',
            'sintomas' => 'required|string|max:1000',
            'observaciones' => 'required|string|max:1000',
            'idHistoriaClinica' => 'required|exists:historiaClinica,id',
            'idVeterinario' => 'required|exists:veterinario,id',
        ];
    }

    public function messages(): array
    {
        return [
            'peso.required' => 'El peso es obligatorio.',
            'peso.numeric' => 'El peso debe ser un valor numérico.',
            'peso.gt' => 'El peso debe ser mayor que cero.',

            'temperatura.required' => 'La temperatura es obligatoria.',
            'temperatura.numeric' => 'La temperatura debe ser un valor numérico.',
            'temperatura.gt' => 'La temperatura debe ser mayor que cero.',

            'sintomas.required' => 'Los síntomas son obligatorios.',

            'observaciones.required' => 'Las observaciones son obligatorias.',

            'idHistoriaClinica.required' => 'La historia clínica es obligatoria.',
            'idHistoriaClinica.exists' => 'La historia clínica seleccionada no existe.',

            'idVeterinario.required' => 'El veterinario es obligatorio.',
            'idVeterinario.exists' => 'El veterinario seleccionado no existe.',
        ];
    }
}
