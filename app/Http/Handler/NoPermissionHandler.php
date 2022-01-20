<?php

namespace App\Http\Handler;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

class NoPermissionHandler
{
    public static function handle($request, Throwable $e): JsonResponse
    {
        return (new Controller())->sendError('You do not have permission to access this resource.', [
            'roles' => $e->getRequiredRoles(),
            'permissions' => $e->getRequiredPermissions(),
        ], 403);
    }
}
