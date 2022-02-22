<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarPacienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "nombres" => "required",
            "apellidos" => "required",
            "edad" => "required|max:3",
            "sexo" => "required|max:9",
            "dni" => "required|unique:pacientes,dni,".$this->route('paciente')->id."|max:8",
            "tipo_sangre" => "required|max:3",
            "telefono" => "required|max:15",
            "correo" => "required|email",
            "direccion" => "required",
        ];
    }
}
