<?php

namespace App\Http\Controllers\Security\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\Permissions\UserRoleRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class UserRolesController extends Controller
{
    /**
     * Implement permission middlewares
     * TODO: Test Controller
     */
    public function __construct()
    {
        $this->middleware('permission:user.roles.list')->only('index');
        $this->middleware('permission:user.roles.attach')->only('store');
        $this->middleware('permission:user.roles.show')->only('show');
        $this->middleware('permission:user.roles.destroy')->only('destroy');
    }

    private function getRoleFromRequest(UserRoleRequest $request): ?Role
    {
        if ($request->has('role_id')) return Role::findOrFail($request->get('role_id'));
        if ($request->has('role_name')) return Role::where('name', $request->get('role_name'))->firstOrFail();
        return null;
    }

    public function index(User $user): JsonResponse
    {
        return $this->sendResponse($user->roles(), "Successfully retrieved assigned roles of user");
    }

    public function store(UserRoleRequest $request, User $user): JsonResponse
    {
        $role = $this->getRoleFromRequest($request);

        return $this->sendResponse([
            'has_role' => $user->assignRole($role)
        ], "Successfully checked if user has role");
    }

    public function show(User $user, string $role) {
        return $this->sendResponse([
            'is_attached' => $user->hasRole($role)
        ], "Successfully checked if user has role");
    }

    public function destroy(User $user) {}
}
