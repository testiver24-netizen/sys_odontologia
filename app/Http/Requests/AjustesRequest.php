<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AjustesRequest extends FormRequest
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
            'nombre'     => ['required', 'string', 'max:150'],
            'decripcion' => ['nullable', 'string', 'max:255'],
            'direccion'  => ['required', 'string', 'max:255'],
            'telefono'   => ['required', 'string', 'max:20'],
            'email'      => ['required', 'email', 'max:100'],
            'divisa'     => ['required', 'string', 'max:50'],
            'url_logo'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'web'        => ['required', 'string', 'max:100'],
        ];
    }
}
