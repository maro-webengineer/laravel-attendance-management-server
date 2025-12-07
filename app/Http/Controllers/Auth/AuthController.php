<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $user = $this->authService->authenticate(
                $validated['email'],
                $validated['password'],
            );

            return response()->json([
                'message' => 'ログインに成功しました。',
                'user_name' => $user->name,
            ]);

        } catch (ValidationException $e) {
            return response()->json($e->errors(), Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json([
            'message' => 'ログアウトしました。',
        ]);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

}
