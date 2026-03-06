<?php

namespace App\Http\Actions\Auth;

use App\Exceptions\DomainException;
use App\Http\Requests\Auth\CreateTokenRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class CreateTokenAction
{
    public function execute(CreateTokenRequest $request): User
    {
        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw new DomainException(
                statusCode: HttpStatus::HTTP_UNPROCESSABLE_ENTITY,
                title: 'Authentication Failed',
                description: 'Incorrect credentials provided.',
            );
        }

        //        $user->tokens()->delete();

        return $user;
    }
}
