<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $id = $this->route('role'); // null al crear, el id (o modelo) al editar
        return [
            'name'=>'required|string|max:100|unique:roles,name,'. $id
        ];
        
    }
     
    
    protected function failedValidation(Validator $validator)
{
    $modal = $this->isMethod('post')
        ? 'modal-rol'
        : 'modal-rol-edit-' . $this->route('id');

    session()->flash('open_modal', $modal);

    parent::failedValidation($validator);
}
  
}
