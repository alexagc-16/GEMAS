<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use Illuminate\Foundation\Http\FormRequest;

class MascotaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $usuario = $this->user();

        // El usuario únicamente puede actualizar la fotografía.
        if (
            $this->isMethod('put') &&
            $usuario &&
            $usuario->tieneRolActivo('usuario')
        ) {
            return [
                'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'eliminar_imagen' => 'nullable|in:0,1',
            ];
        }

        return [
            'nombre' => 'required|string|max:50',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'especie' => 'required|string|max:50',
            'raza' => 'required|string|max:50',
            'sexo' => 'required|in:Macho,Hembra',
            'fechaNacimiento' => 'required|date',
            'color' => 'required|string|max:50',
            'peso' => 'required|numeric',

            'idUsuario' => [
                'required',
                function ($attribute, $value, $fail) {
                    $usuarioValido = Usuario::query()
                        ->whereKey($value)
                        ->whereNull('cuentaDesactivadaEn')
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'usuario');
                        })
                        ->exists();

                    if (!$usuarioValido) {
                        $fail('El propietario seleccionado no es válido o su cuenta está desactivada.');
                    }
                },
            ],

            'eliminar_imagen' => 'nullable|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la mascota es obligatorio.',
            'nombre.max' => 'El nombre de la mascota no puede superar los 50 caracteres.',

            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe estar en formato JPG, JPEG, PNG o WEBP.',
            'imagen.max' => 'La imagen no puede superar los 2 MB.',

            'especie.required' => 'La especie es obligatoria.',
            'especie.max' => 'La especie no puede superar los 50 caracteres.',

            'raza.required' => 'La raza es obligatoria.',
            'raza.max' => 'La raza no puede superar los 50 caracteres.',

            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.in' => 'El sexo seleccionado no es válido.',

            'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fechaNacimiento.date' => 'La fecha de nacimiento no es válida.',

            'color.required' => 'El color es obligatorio.',
            'color.max' => 'El color no puede superar los 50 caracteres.',

            'peso.required' => 'El peso es obligatorio.',
            'peso.numeric' => 'El peso debe ser un valor numérico.',

            'idUsuario.required' => 'Debes seleccionar un propietario.',
        ];
    }
}

