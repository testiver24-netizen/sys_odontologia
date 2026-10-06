<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
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
    $id = $this->route('id');   // null al crear, !==null al editar

    return [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|max:255|unique:users,email,' . $id,
        'estado'   => 'required|in:activo,inactivo',
        'rol'      => 'required|string|not_in:SUPER-ADMIN',
        'password' => $id
                        ? 'nullable|string|min:6|confirmed'
                        : 'required|string|min:6|confirmed',
    ];
   
}
public function messages(): array
{
    return [
        'rol.not_in' => 'Ese rol no está permitido.',
    ];
}
protected function failedValidation(Validator $validator)
{
    $id = $this->route('id');

    session()->flash(
        'open_modal',
        $id ? 'modal-usuario-edit-' . $id : 'modal-usuario'
    );

    parent::failedValidation($validator);
}
}
