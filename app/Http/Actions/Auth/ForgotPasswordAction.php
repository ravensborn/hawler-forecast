<?php

namespace App\Http\Actions\Auth;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Support\Facades\Cache;

class ForgotPasswordAction
{
    public function execute(ForgotPasswordRequest $request): void
    {
        $user = User::query()->where('email', $request->email)->first();

        if (! $user) {

            return;
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put(
            'password_reset_code:'.$user->email,
            $code,
            now()->addMinutes(60)
        );

        $user->notify(new ResetPasswordNotification($code));
    }
}
