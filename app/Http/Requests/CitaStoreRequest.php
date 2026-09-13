<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CitaStoreRequest extends FormRequest
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
            'hora' => 'required|date_format:H:i',
            'motivo' => 'required|string|max:150',
            'estado' => 'required|in:Pendiente,Confirmada,Atendida,Cancelada',
            'idMascota' => 'required|exists:mascota,id',
            'idVeterinario' => 'required|exists:veterinario,id',
            'idServicio' => 'required|exists:servicio,id',
        ];
    }

    public function messages(): array
    {
        return [
            'fecha.required' => 'La fecha de la cita es obligatoria.',
            'fecha.date' => 'La fecha de la cita debe tener un formato válido.',

            'hora.required' => 'La hora de la cita es obligatoria.',
            'hora.date_format' => 'La hora de la cita debe tener un formato válido.',

            'motivo.required' => 'El motivo de la cita es obligatorio.',
            'motivo.max' => 'El motivo de la cita no puede superar los 150 caracteres.',

            'estado.required' => 'El estado de la cita es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',

            'idMascota.required' => 'La mascota es obligatoria.',
            'idMascota.exists' => 'La mascota seleccionada no existe.',

            'idVeterinario.required' => 'El veterinario es obligatorio.',
            'idVeterinario.exists' => 'El veterinario seleccionado no existe.',

            'idServicio.required' => 'El servicio es obligatorio.',
            'idServicio.exists' => 'El servicio seleccionado no existe.',
        ];
    }
}
