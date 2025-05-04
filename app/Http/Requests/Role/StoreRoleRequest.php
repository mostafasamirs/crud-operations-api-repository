<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|min:2|max:255',
            'is_active'=>'nullable',
            'permissionArray.*'=>'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => lang('api::role.name_required'),
            'name.string' => lang('api::role.name_string'),
            'name.min' => lang('api::role.name_min'),
            'name.max' => lang('api::role.name_max'),
        ];
    }

}
