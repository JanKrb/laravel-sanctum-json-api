<?php

namespace App\Http\Requests\Security\Auth;

use App\Http\Requests\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required_without:name', 'exists:users,email'],
            'name' => ['required_without:email', 'exists:users,name'],
            'password' => ['required'],
            'remember_me' => ['nullable', 'boolean']
        ];
    }
}
