<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            logger()->info('ログイン成功', ['email' => $validated['email']]);
            $request->session()->regenerate();

            return response()->json(['message' => 'ログインに成功しました。']);
        }

        logger()->error('ログイン失敗', ['email' => $validated['email']]);

        return response()->json([
            'message' => 'ログインに失敗しました。',
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function logout(Request $request): JsonResponse
    {
        if (Auth::guard()->guest()) {
            return response()->json([
                'message' => '既にログアウトしています。',
            ], Response::HTTP_BAD_REQUEST);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'ログアウトしました。',]);
    }

}
