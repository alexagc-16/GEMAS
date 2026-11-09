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
            'fecha' => $this->isMethod('post')
            ? 'required|date|after_or_equal:today'
            : 'required|date',
            'hora' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {

                    $fecha = $this->input('fecha');

                    if (!$fecha || !$value) {
                        return;
                    }

                    try {
                        // Construir la fecha y hora seleccionadas en Colombia.
                        $fechaHoraCita = \Carbon\Carbon::createFromFormat(
                            'Y-m-d H:i',
                            $fecha . ' ' . $value,
                            'America/Bogota'
                        );

                        // Obtener la hora actual de Colombia.
                        $ahora = \Carbon\Carbon::now('America/Bogota');

                        // Rechazar únicamente las citas anteriores o iguales a la hora actual.
                        if ($fechaHoraCita->lessThanOrEqualTo($ahora)) {
                            $fail('No puedes agendar una cita en una hora anterior o igual a la actual.');
                        }

                    } catch (\Exception $e) {
                        return;
                    }
                },
            ],
            'motivo' => 'required|string|max:150',
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
            'fecha.after_or_equal' => 'No puedes agendar una cita en una fecha anterior a la actual.',

            'hora.required' => 'La hora de la cita es obligatoria.',
            'hora.date_format' => 'La hora de la cita debe tener un formato válido.',

            'motivo.required' => 'El motivo de la cita es obligatorio.',
            'motivo.string' => 'El motivo debe ser texto.',
            'motivo.max' => 'El motivo de la cita no puede superar los 150 caracteres.',

            'idMascota.required' => 'La mascota es obligatoria.',
            'idMascota.exists' => 'La mascota seleccionada no existe.',

            'idVeterinario.required' => 'El veterinario es obligatorio.',
            'idVeterinario.exists' => 'El veterinario seleccionado no existe.',

            'idServicio.required' => 'El servicio es obligatorio.',
            'idServicio.exists' => 'El servicio seleccionado no existe.',
        ];
    }
}

