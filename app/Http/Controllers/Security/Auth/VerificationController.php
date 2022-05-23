<?php

namespace App\Http\Controllers\Security\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use function auth;
use function event;
use function response;

class VerificationController extends Controller
{
    /**
     * @param Request $request
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     * TODO: Unit Test
     */
    public function verify(Request $request, int $user_id) {
        $user = User::findOrFail($user_id);

        if (!$request->hasValidSignature()) {
            return $this->sendError('Invalid/Expired url provided.', [], 401);
        }

        if (!$user->hasVerifiedEmail()) {
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }
        }

        return $this->sendResponse([], "Email verified successfully.");
    }

    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) {
            return $this->sendError('Email already verified.', [], 400);
        }

        auth()->user()->sendEmailVerificationNotification();

        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}
