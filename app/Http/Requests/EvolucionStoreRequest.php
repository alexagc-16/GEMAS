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
            'sintomas' => 'required|string|max:255',
            'observaciones' => 'required|string|max:255',
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
            'sintomas.max' => 'Los síntomas no pueden superar los 255 caracteres.',

            'observaciones.required' => 'Las observaciones son obligatorias.',
            'observaciones.max' => 'Las observaciones no pueden superar los 255 caracteres.',

            'idHistoriaClinica.required' => 'La historia clínica es obligatoria.',
            'idHistoriaClinica.exists' => 'La historia clínica seleccionada no existe.',

            'idVeterinario.required' => 'El veterinario es obligatorio.',
            'idVeterinario.exists' => 'El veterinario seleccionado no existe.',
        ];
    }
}
