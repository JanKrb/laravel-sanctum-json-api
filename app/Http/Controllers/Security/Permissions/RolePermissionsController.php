<?php

namespace App\Http\Controllers\Security\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\Permissions\RolePermissionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsController extends Controller
{
    /**
     * Implement permission middlewares
     * TODO: Test Controller
     */
    public function __construct()
    {
        $this->middleware('permission:role.*.permissions.list')->only('index');
        $this->middleware('permission:role.*.permissions.attach')->only('store');
        $this->middleware('permission:role.*.permissions.show')->only('show');
        $this->middleware('permission:role.*.permissions.detach')->only('destroy');
    }

    private function getPermissionFromRequest(RolePermissionRequest $request): ?Permission
    {
        if ($request->has('permission_id')) return Permission::findOrFail($request->get('permission_id'));
        if ($request->has('permission_name')) return Permission::where('name', $request->get('permission_name'))->firstOrFail();
        return null;
    }

    public function index(Role $role): JsonResponse
    {
        return $this->sendResponse($role->permissions(), "Successfully retrieved permissions attached to role");
    }

    public function store(RolePermissionRequest $request, Role $role): JsonResponse
    {
        $permission = $this->getPermissionFromRequest($request);

        $role->givePermissionTo($permission);

        return $this->sendResponse($permission, "Permission has been successfully attached to role");
    }

    /**
     * Return if permission is attached to role
     * @param RolePermissionRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function show(RolePermissionRequest $request, Role $role): JsonResponse
    {
        $permission = $this->getPermissionFromRequest($request);

        return $this->sendResponse([
            "is_attached" => $role->checkPermissionTo($permission)
        ], "Successfully checked for connection between role and permission");
    }

    public function detach(RolePermissionRequest $request, Role $role): JsonResponse
    {
        $permission = $this->getPermissionFromRequest($request);

        if (! $role->checkPermissionTo($permission)) {
            return $this->sendError("Permission is not attached to role");
        }

        $role->revokePermissionTo($permission);

        return $this->sendResponse($permission, "Successfully revoked permission from role");
    }
}
