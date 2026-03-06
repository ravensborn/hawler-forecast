<?php

namespace App\Http\Actions\Auth;

use App\Exceptions\DomainException;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class UpdatePasswordAction
{
    public function execute(UpdatePasswordRequest $request): void
    {
        $user = $request->user();

        if (! Hash::check($request->currentPassword, $user->password)) {
            throw new DomainException(
                statusCode: HttpStatus::HTTP_UNPROCESSABLE_ENTITY,
                title: 'Password Update Failed',
                description: 'The current password is incorrect.',
            );
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $user->tokens()->delete();
    }
}
