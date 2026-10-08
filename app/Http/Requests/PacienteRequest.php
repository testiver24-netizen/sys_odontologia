<?php

namespace App\Http\Requests;

use App\Models\Paciente;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PacienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // En create no hay parámetros en la ruta; en edit trae el id del paciente
        $param = $this->route()?->parameters() ? collect($this->route()->parameters())->first() : null;

        // Si el parámetro ya es un modelo (route model binding), úsalo; si no, búscalo
        $paciente = $param instanceof Paciente
            ? $param
            : ($param ? Paciente::with('user')->find($param) : null);

        return [
            'nombres'          => 'required|string|max:150',
            'apellidos'        => 'required|string|max:150',
            'tipo_documento'   => 'required|in:CI,CE,Pasaporte',
            'numero_documento' => [
                'required', 'string', 'max:20',
                Rule::unique('pacientes', 'numero_documento')->ignore($paciente?->id),
            ],
            'fecha_nacimiento' => 'required|date',
            'genero'           => 'required|in:M,F',
            'direccion'        => 'required|string',
            'telefono'         => 'required|string|max:50',
            'email'            => [
                'required', 'email', 'max:150',
                Rule::unique('users', 'email')->ignore($paciente?->user?->id),
            ],
            'grupo_sanguineo'     => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'alergias'            => 'nullable|string',
            'enfermedades'        => 'nullable|string',
            'medicamentos'        => 'nullable|string',
            'habitos'             => 'nullable|array',
            'antecedentes'        => 'nullable|array',
            'contacto_emergencia' => 'nullable|string|max:150',
            'telefono_emergencia' => 'nullable|string|max:50',
            'observaciones'       => 'nullable|string',
        ];
    }
}