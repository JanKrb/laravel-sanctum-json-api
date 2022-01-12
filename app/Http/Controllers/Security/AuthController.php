<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\Auth\LoginRequest;
use App\Http\Requests\Security\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Authenticate user and create token
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'name', 'password']);

        // Return user info if already logged in
        if (Auth::check()) return $this->user($request);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createPersonalAccessToken($request->remember_me);

            return $this->sendResponse([
                'token' => $token,
                'user' => $user
            ], 'User authenticated successfully.');
        }

        return $this->sendError('User authentication failed.', [
            'message' => 'Invalid credentials.'
        ], 401);
    }
}
