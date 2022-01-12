<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    protected function redirectTo($request): JsonResponse
    {
        throw new HttpResponseException((new Controller())->sendError('Unauthorized Request', [
            'failure_reason' => 'Fresh Access Token Required'
        ], 401));
    }
}
