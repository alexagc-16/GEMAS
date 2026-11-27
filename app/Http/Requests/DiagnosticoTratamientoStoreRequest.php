<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DiagnosticoTratamientoStoreRequest extends FormRequest
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
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'medicamento' => 'required|string',
            'dosis' => 'required|string|max:170',
            'frecuencia' => 'required|string|max:170',
            'duracion' => 'required|string|max:170',
            'procedimiento' => 'required|string',
            'examenOrdenado' => 'required|string',
            'indicaciones' => 'required|string',
            'fecha' => 'required|date',
            'idEvolucion' => 'required|exists:evolucion,id',
        ];
    }

    public function messages(): array
    {
        return [
            'diagnostico.required' => 'El diagnóstico es obligatorio.',

            'tratamiento.required' => 'El tratamiento es obligatorio.',

            'medicamento.required' => 'El medicamento es obligatorio.',

            'dosis.required' => 'La dosis es obligatoria.',
            'dosis.max' => 'La dosis no puede superar los 170 caracteres.',

            'frecuencia.required' => 'La frecuencia es obligatoria.',
            'frecuencia.max' => 'La frecuencia no puede superar los 170 caracteres.',

            'duracion.required' => 'La duración es obligatoria.',
            'duracion.max' => 'La duración no puede superar los 170 caracteres.',

            'procedimiento.required' => 'El procedimiento es obligatorio.',

            'examenOrdenado.required' => 'El examen ordenado es obligatorio.',

            'indicaciones.required' => 'Las indicaciones son obligatorias.',

            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe tener un formato válido.',

            'idEvolucion.required' => 'La evolución es obligatoria.',
            'idEvolucion.exists' => 'La evolución seleccionada no existe.',
        ];
    }
}
