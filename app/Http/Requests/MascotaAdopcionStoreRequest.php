<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MascotaAdopcionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:50',
            'imagen' => $this->isMethod('POST')
                ? 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
                : 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'especie' => 'required|string|max:50|in:Perro,Gato',
            'raza' => 'nullable|string|max:50',
            'sexo' => 'required|in:Macho,Hembra',
            'fechaNacimiento' => 'nullable|date|before_or_equal:today',
            'color' => 'nullable|string|max:50',
            'peso' => 'nullable|numeric|min:0',
            'descripcion' => 'required|string',
            'estado' => 'required|in:En adopción,Adoptada,No disponible',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la mascota es obligatorio.',
            'especie.required' => 'Selecciona la especie de la mascota.',
            'especie.in' => 'La especie seleccionada no es válida.',
            'sexo.required' => 'Selecciona el sexo de la mascota.',
            'raza.max' => 'La raza no debe superar los 50 caracteres.',
            'color.max' => 'El color no debe superar los 50 caracteres.',
            'fechaNacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser futura.',
            'peso.numeric' => 'El peso debe ser un valor numérico.',
            'peso.min' => 'El peso no puede ser negativo.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'imagen.required' => 'Debes seleccionar una fotografía.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe estar en formato JPG, JPEG, PNG o WEBP.',
            'imagen.max' => 'La imagen no debe superar los 2 MB.',
            'estado.required' => 'Selecciona el estado de la mascota.',
        ];
    }
}
