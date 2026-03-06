<?php

namespace App\Http\Actions\Auth;

use App\Exceptions\DomainException;
use App\Http\Requests\Auth\VerifyResetCodeRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class VerifyResetCodeAction
{
    public function execute(VerifyResetCodeRequest $request): string
    {
        $cacheKey = 'password_reset_code:'.$request->email;
        $storedCode = Cache::get($cacheKey);

        if (! $storedCode || $storedCode !== $request->code) {
            throw new DomainException(
                statusCode: HttpStatus::HTTP_UNPROCESSABLE_ENTITY,
                title: 'Invalid Code',
                description: 'The reset code is invalid or has expired.',
            );
        }

        Cache::forget($cacheKey);

        $resetToken = Str::random(64);

        Cache::put(
            'password_reset_token:'.$request->email,
            $resetToken,
            now()->addMinutes(10)
        );

        return $resetToken;
    }
}
