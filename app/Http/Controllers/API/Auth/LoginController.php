<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Constants\AuthConstants;
use App\Http\Controllers\API\BaseController;

class LoginController extends BaseController
{
    /**
     * @param AuthRequest $request
     * @return JsonResponse
     */
    public function login(AuthRequest $request): JsonResponse
    {
        if (Auth::attempt($request->all())) {
            $user = Auth::user();
            $success = $user->createToken('MyApp')->plainTextToken;

            return $this->sendResponse(['token' => $success], AuthConstants::LOGIN);
        }

        return $this->sendError(AuthConstants::VALIDATION);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        if (Auth::check()) {
            $user = Auth::user();

            $user->tokens()->delete();

            return $this->sendResponse([], AuthConstants::LOGOUT);
        }

        return $this->sendError(AuthConstants::UNAUTHORIZED);
    }

    /**
     * @return JsonResponse
     */
    public function details(): JsonResponse
    {
        if (Auth::check()) {
            $user = Auth::user();

            return $this->sendResponse($user->toArray(), '');
        }

        return $this->sendError(AuthConstants::UNAUTHORIZED);
    }
}
