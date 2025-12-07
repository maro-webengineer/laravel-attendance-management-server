<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function authenticate(string $email, string $password)
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {

            logger()->warning('ログイン失敗', [
                'email' => $email,
                'ip' => request()->ip(),
            ]);

            throw ValidationException::withMessages([
                'message' => ['メールアドレスまたはパスワードが正しくありません。'],
            ]);
        }

        logger()->info('ログイン成功', [
            'ip' => request()->ip(),
            'user_id' => Auth::user()->id,
            'email' => json_encode($email, JSON_UNESCAPED_UNICODE),
        ]);

        request()->session()->regenerate();

        return Auth::user();
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
    }
}
