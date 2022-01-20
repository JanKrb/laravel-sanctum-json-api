<?php

namespace App\Http\Handler;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

class ValidationErrorHandler extends Controller
{
    public static function handle($request, Throwable $e): JsonResponse
    {
        return (new Controller())->sendError($e->getMessage(), $e->validator->errors()->getMessages(), 422);
    }
}
