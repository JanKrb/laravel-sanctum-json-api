<?php

namespace App\Http\Handler;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

class NotFoundHandler
{
    public static function handle($request, Throwable $e): JsonResponse
    {
        return (new Controller())->sendError('The requested model isn\'t accessable or does not exist.', []);
    }
}
