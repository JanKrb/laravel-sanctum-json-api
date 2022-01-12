<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormRequest extends Request
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $this->validator->errors();

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $errors,
                'message' => 'The given data was invalid.',
            ], 422)
        );
    }
}
