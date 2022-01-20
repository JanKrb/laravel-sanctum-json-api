<?php

namespace App\Http\Requests\Security\Permissions;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255|unique:roles,name',
            'guard_name' => 'nullable|string|max:255',
        ];
    }
}
