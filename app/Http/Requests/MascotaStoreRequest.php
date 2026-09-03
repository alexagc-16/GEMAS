<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MascotaStoreRequest extends FormRequest
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
            'nombre' => 'required|string|max:50', 
            'especie' => 'required|string|max:50', 
            'raza' => 'required|string|max:50', 
            'sexo' => 'required|string', 
            'fechaNacimiento' => 'required|date', 
            'color' => 'required|string|max:50', 
            'peso' => 'required|numeric', 
            'idUsuario' => 'required|exists:usuario,id',
        ];
    }

    public function messages(): array
    {
        return [ 
            'nombre.required' => 'El nombre de la mascota es obligatorio.', 
            'nombre.max' => 'El nombre de la mascota no puede superar los 50 caracteres.', 
            'especie.required' => 'La especie es obligatoria.', 
            'especie.max' => 'La especie no puede superar los 50 caracteres.', 
            'raza.required' => 'La raza es obligatoria.', 
            'raza.max' => 'La raza no puede superar los 50 caracteres.', 
            'sexo.required' => 'El sexo es obligatorio.',  
            'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.', 
            'color.required' => 'El color es obligatorio.', 
            'color.max' => 'El color no puede superar los 50 caracteres.', 
            'peso.required' => 'El peso es obligatorio.', 
            'idUsuario.required' => 'El usuario es obligatorio.', 
            'idUsuario.exists' => 'El usuario seleccionado no existe.', 
        ];
    }

}
