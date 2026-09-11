<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HorarioStoreRequest extends FormRequest
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
            'diaSemana' => 'required|string|max:25',
            'horaInicio' => 'required|date_format:H:i',
            'horaFin' => 'required|date_format:H:i|after:horaInicio',
            'idVeterinario' => 'required|exists:veterinario,id',
        ];

    }

    public function messages(): array
{
    return [
        'diaSemana.required' => 'El día de la semana es obligatorio.',
        'diaSemana.max' => 'El día de la semana no puede superar los 25 caracteres.',

        'horaInicio.required' => 'La hora de inicio es obligatoria.',
        'horaInicio.date_format' => 'La hora de inicio debe tener un formato válido.',

        'horaFin.required' => 'La hora de finalización es obligatoria.',
        'horaFin.date_format' => 'La hora de finalización debe tener un formato válido.',

        'idVeterinario.required' => 'El veterinario es obligatorio.',
        'idVeterinario.exists' => 'El veterinario seleccionado no existe.',
    ];
}
}
