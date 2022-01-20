<?php

namespace App\Http\Controllers\Security\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\Permissions\CreatePermissionRequest;
use App\Http\Requests\Security\Permissions\CreateRoleRequest;
use App\Http\Requests\Security\Permissions\UpdatePermissionRequest;
use App\Http\Requests\Security\Permissions\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Implement permission middlewares
     */
    public function __construct()
    {
        $this->middleware('permission:permission.list')->only('index');
        $this->middleware('permission:permission.create')->only('store');
        $this->middleware('permission:permission.show')->only('show');
        $this->middleware('permission:permission.update')->only('update');
        $this->middleware('permission:permission.delete')->only('destroy');
    }

    public function index() {
        return $this->sendResponse(Permission::all(), "Successfully retrieved permissions");
    }

    public function store(CreatePermissionRequest $request) {
        $permission = Permission::create($request->validated());
        return $this->sendResponse($permission, "Successfully created permission");
    }

    public function show(Permission $permission) {
        return $this->sendResponse($permission, "Successfully retrieved permission");
    }

    public function update(UpdatePermissionRequest $request, Permission $permission) {
        $permission->update($request->validated());
        return $this->sendResponse($permission, "Successfully updated permission");
    }

    public function destroy(Permission $permission) {
        $permission->delete();
        return $this->sendResponse($permission, "Successfully deleted permission");
    }
}
