<?php

namespace App\Http\Actions\Auth;

use App\Exceptions\DomainException;
use App\Http\Requests\Auth\ResetPasswordWithTokenRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class ResetPasswordWithTokenAction
{
    public function execute(ResetPasswordWithTokenRequest $request): void
    {
        $cacheKey = 'password_reset_token:'.$request->email;
        $storedToken = Cache::get($cacheKey);

        if (! $storedToken || $storedToken !== $request->token) {
            throw new DomainException(
                statusCode: HttpStatus::HTTP_UNPROCESSABLE_ENTITY,
                title: 'Password Reset Failed',
                description: 'The reset token is invalid or has expired.',
            );
        }

        $user = User::query()->where('email', $request->email)->first();

        if (! $user) {
            throw new DomainException(
                statusCode: HttpStatus::HTTP_UNPROCESSABLE_ENTITY,
                title: 'Password Reset Failed',
                description: 'User not found.',
            );
        }

        Cache::forget($cacheKey);

        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->setRememberToken(Str::random(60));

        $user->save();

        $user->tokens()->delete();

        event(new PasswordReset($user));
    }
}
