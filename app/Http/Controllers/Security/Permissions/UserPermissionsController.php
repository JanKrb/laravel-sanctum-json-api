<?php

namespace App\Http\Controllers\Security\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\Permissions\UserPermissionRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserPermissionsController extends Controller
{
    /**
     * Implement permission middlewares
     * TODO: Test Controller
     */
    public function __construct()
    {
        $this->middleware('permission:user.permissions.list')->only('index');
        $this->middleware('permission:user.permissions.attach')->only('store');
        $this->middleware('permission:user.permissions.show')->only('show');
        $this->middleware('permission:user.permissions.detach')->only('destroy');
    }

    private function getPermissionFromRequest(UserPermissionRequest $request): ?Permission
    {
        if ($request->has('permission_id')) return Permission::findOrFail($request->get('permission_id'));
        if ($request->has('permission_name')) return Permission::where('name', $request->get('permission_name'))->firstOrFail();
        return null;
    }

    public function index(User $user): JsonResponse
    {
        return $this->sendResponse($user->permissions(), "Successfully retrieved permissions attached to user");
    }

    public function store(UserPermissionRequest $request, User $user): JsonResponse
    {
        $permission = $this->getPermissionFromRequest($request);

        $user->givePermissionTo($permission);

        return $this->sendResponse($permission, "Permission has been successfully attached to user");
    }

    /**
     * Return if permission is attached to user
     * @param User $user
     * @param string $permission
     * @return JsonResponse
     */
    public function show(User $user, string $permission): JsonResponse
    {
        return $this->sendResponse([
            "is_attached" => $user->hasPermissionTo($permission)
        ], "Successfully checked for connection between user and permission");
    }

    public function destroy(User $user, string $permission): JsonResponse
    {
        if (! $user->checkPermissionTo($permission)) {
            return $this->sendError("Permission is not attached to user");
        }

        $user->revokePermissionTo($permission);

        return $this->sendResponse([
            'permission_name' => $permission
        ], "Successfully revoked permission from user");
    }
}
