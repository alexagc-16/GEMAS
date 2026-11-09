<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CancelacionCitaStoreRequest extends FormRequest
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
            'idCita' => [
                'required',
                'integer',
                'exists:cita,id',
                Rule::unique('cancelacionCita', 'idCita'),
            ],

            'motivo' => 'nullable|string|max:250',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'idCita.required' => 'Debes seleccionar la cita que deseas cancelar.',
            'idCita.integer' => 'La cita seleccionada no es válida.',
            'idCita.exists' => 'La cita seleccionada no existe.',
            'idCita.unique' => 'Esta cita ya tiene un registro de cancelación.',

            'motivo.string' => 'El motivo de la cancelación debe ser texto.',
            'motivo.max' => 'El motivo de la cancelación no puede superar los 250 caracteres.',
            'motivo.required' => 'Debes indicar el motivo de la cancelación.',
        ];
    }
}