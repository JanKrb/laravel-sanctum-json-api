<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Implement permission middlewares
     */
    public function __construct()
    {
        $this->middleware('permission:role.list')->only('index');
        $this->middleware('permission:role.create')->only('store');
        $this->middleware('permission:role.show')->only('show');
        $this->middleware('permission:role.update')->only('update');
        $this->middleware('permission:role.delete')->only('destroy');
    }

    public function index() {
        return $this->sendResponse(Role::all(), "Successfully retrieved roles");
    }
    public function show() {}
    public function update() {}
    public function destroy() {}
}
