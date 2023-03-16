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

            $user->tokens()->delete();

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
        $user = Auth::user();

        $user->tokens()->delete();

        return $this->sendResponse([], AuthConstants::LOGOUT);
    }

    /**
     * @return JsonResponse
     */
    public function details(): JsonResponse
    {
        $user = Auth::user();

        return $this->sendResponse($user->toArray(), '');
    }
}
