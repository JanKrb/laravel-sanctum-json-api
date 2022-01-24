<?php

namespace App\Http\Requests\Security\Permissions;

use Illuminate\Foundation\Http\FormRequest;

class UserRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role_name' => 'required_without:role_id|string|max:255|exists:roles,name',
            'role_id' => 'required_without:role_name|int|exists:roles,id'
        ];
    }
}
