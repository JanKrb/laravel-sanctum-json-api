<?php

namespace App\Http\Requests\Security\Permissions;

use Illuminate\Foundation\Http\FormRequest;

class RolePermissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permission_name' => 'required_without:permission_id|string|max:255|exists:permissions,name',
            'permission_id' => 'required_without:permission_name|int|exists:permissions,id'
        ];
    }
}
