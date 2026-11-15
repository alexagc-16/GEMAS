<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinalizarConsultaRequest extends FormRequest
{
    /**
     * Determina si el usuario puede enviar los datos de la consulta.
     * La autorización específica se comprueba en CitaService.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define las reglas de validación de la consulta veterinaria.
     */
    public function rules(): array
    {
        return [
            // Veterinario que registra la consulta.
            'idVeterinario' => 'required|exists:veterinario,id',

            // Información general de la evolución.
            'peso' => 'required|numeric|min:0.01',
            'temperatura' => 'required|numeric|min:0.01',
            'sintomas' => 'required|string',
            'observaciones' => 'required|string',

            // Debe existir al menos un registro de diagnóstico.
            'diagnosticos' => 'required|array|min:1',

            // Cada registro debe tener una estructura de arreglo.
            'diagnosticos.*' => 'required|array',

            // Información opcional de cada diagnóstico y tratamiento.
            'diagnosticos.*.diagnostico' => 'nullable|string',
            'diagnosticos.*.tratamiento' => 'nullable|string',
            'diagnosticos.*.medicamento' => 'nullable|string',
            'diagnosticos.*.dosis' => 'nullable|string|max:170',
            'diagnosticos.*.frecuencia' => 'nullable|string|max:170',
            'diagnosticos.*.duracion' => 'nullable|string|max:170',
            'diagnosticos.*.procedimiento' => 'nullable|string',
            'diagnosticos.*.examenOrdenado' => 'nullable|string',
            'diagnosticos.*.indicaciones' => 'nullable|string',
        ];
    }

    /**
     * Comprueba que al menos uno de los registros tenga información.
     * No permite finalizar una consulta con todos los campos vacíos.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $diagnosticos = $this->input('diagnosticos', []);

            $hayInformacion = false;

            foreach ($diagnosticos as $registro) {

                // Ignorar registros que no tengan una estructura válida.
                if (!is_array($registro)) {
                    continue;
                }

                foreach ([
                    'diagnostico',
                    'tratamiento',
                    'medicamento',
                    'dosis',
                    'frecuencia',
                    'duracion',
                    'procedimiento',
                    'examenOrdenado',
                    'indicaciones',
                ] as $campo) {

                    if (trim((string) ($registro[$campo] ?? '')) !== '') {
                        $hayInformacion = true;
                        break 2;
                    }
                }
            }

            if (!$hayInformacion) {
                $validator->errors()->add(
                    'diagnosticos',
                    'Registra al menos un diagnóstico, tratamiento, medicamento, procedimiento, examen o indicación.'
                );
            }
        });
    }
}

