<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use App\Models\Veterinario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VeterinarioStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Identificar si estamos actualizando un veterinario
        $id = $this->route('veterinario') ?? $this->route('id');

        $veterinario = $id ? Veterinario::find($id) : null;

        // Buscar la cuenta asociada mediante el documento actual
        $usuario = $veterinario
            ? Usuario::where('documentoIdentidad', $veterinario->documentoIdentidad)->first()
            : null;

        // Validar documento en ambas tablas
        $documentoVeterinario = Rule::unique('veterinario', 'documentoIdentidad');
        $documentoUsuario = Rule::unique('usuario', 'documentoIdentidad');

        // Validar correo en ambas tablas
        $emailVeterinario = Rule::unique('veterinario', 'email');
        $emailUsuario = Rule::unique('usuario', 'email');

        // Al actualizar, excluir los registros correspondientes
        if ($veterinario) {
            $documentoVeterinario->ignore($veterinario->id);
            $emailVeterinario->ignore($veterinario->id);
        }

        if ($usuario) {
            $documentoUsuario->ignore($usuario->id);
            $emailUsuario->ignore($usuario->id);
        }

        return [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',

            'documentoIdentidad' => [
                'required',
                'string',
                'max:20',
                $documentoVeterinario,
                $documentoUsuario,
            ],

            'telefono' => 'required|string|max:20',

            'email' => [
                'required',
                'email',
                'max:100',
                $emailVeterinario,
                $emailUsuario,
            ],

            'especialidad' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del veterinario es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',

            'apellido.required' => 'El apellido del veterinario es obligatorio.',
            'apellido.max' => 'El apellido no puede superar los 100 caracteres.',

            'documentoIdentidad.required' => 'El documento de identidad es obligatorio.',
            'documentoIdentidad.max' => 'El documento de identidad no puede superar los 20 caracteres.',
            'documentoIdentidad.unique' => 'Este documento de identidad ya se encuentra registrado.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.max' => 'El correo electrónico no puede superar los 100 caracteres.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado.',

            'especialidad.required' => 'La especialidad es obligatoria.',
            'especialidad.max' => 'La especialidad no puede superar los 100 caracteres.',
        ];
    }
}
