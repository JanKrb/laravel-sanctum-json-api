<?php

namespace App\Http\Handler;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

class UnauthenticatedHandler
{
    public static function handle($request, Throwable $e): JsonResponse
    {
        return (new Controller())->sendError('You are unable to access this resource, while being logged out.', [], 401);
    }
}
