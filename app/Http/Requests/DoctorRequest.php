<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // En store no hay parámetros en la ruta; en update trae el id del doctor
        $param = $this->route()?->parameters() ? collect($this->route()->parameters())->first() : null;

        // Si el parámetro ya es un modelo (route model binding), úsalo; si no, búscalo
        $doctor = $param instanceof Doctor
            ? $param
            : ($param ? Doctor::find($param) : null);

        return [
            'nombres' => 'required|string|min:3|max:200',
            'apellidos' => 'required|string|min:3|max:200',
            'tipo_documento' => 'required|in:CI,CE,PASAPORTE',
            'numero_documento' => [
                'required', 'string', 'min:3', 'max:50',
                Rule::unique('doctors', 'numero_documento')->ignore($doctor?->id),
            ],
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:M,F',
            'direccion' => 'required|string',
            'telefono' => 'required|string|min:6|max:10',
            'especialidad_id' => 'required|string',
            'colegiatura' => [
                'required', 'string', 'min:3', 'max:150',
                Rule::unique('doctors', 'colegiatura')->ignore($doctor?->id),
            ],
            'email' => [
                'required', 'email',
                Rule::unique('users', 'email')->ignore($doctor?->user_id),
            ],
            'descripcion' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'fotografia' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:2048',
        ];
    }
}