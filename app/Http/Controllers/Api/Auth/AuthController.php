<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Actions\Auth\CreateTokenAction;
use App\Http\Actions\Auth\ForgotPasswordAction;
use App\Http\Actions\Auth\ResetPasswordWithTokenAction;
use App\Http\Actions\Auth\UpdatePasswordAction;
use App\Http\Actions\Auth\VerifyResetCodeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateTokenRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordWithTokenRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\VerifyResetCodeRequest;
use App\Http\Resources\Auth\UserResource;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

#[Group('Dashboard')]
class AuthController extends Controller
{
    public function createToken(CreateTokenRequest $request, CreateTokenAction $action): JsonResponse
    {
        $user = $action->execute($request);

        return response()->json([
            'data' => [
                'token' => $user->createToken('token')->plainTextToken,
                'user' => new UserResource($user),
            ],
        ]);
    }

    public function getUser(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function logout(): Response
    {
        request()->user()->tokens()->delete();

        return response()->noContent();
    }
//
//    public function updatePassword(UpdatePasswordRequest $request, UpdatePasswordAction $action): JsonResponse
//    {
//        $action->execute($request);
//
//        return response()->json([
//            'data' => [
//                'message' => 'Password updated successfully. All sessions have been logged out.',
//            ],
//        ]);
//    }
//
//    public function forgotPassword(ForgotPasswordRequest $request, ForgotPasswordAction $action): JsonResponse
//    {
//        $action->execute($request);
//
//        return response()->json([
//            'data' => [
//                'message' => 'Password reset code sent to your email.',
//            ],
//        ]);
//    }
//
//    public function verifyResetCode(VerifyResetCodeRequest $request, VerifyResetCodeAction $action): JsonResponse
//    {
//        $token = $action->execute($request);
//
//        return response()->json([
//            'data' => [
//                'message' => 'Code verified successfully.',
//                'token' => $token,
//            ],
//        ]);
//    }
//
//    public function resetPasswordWithToken(ResetPasswordWithTokenRequest $request, ResetPasswordWithTokenAction $action): JsonResponse
//    {
//        $action->execute($request);
//
//        return response()->json([
//            'data' => [
//                'message' => 'Password has been reset successfully.',
//            ],
//        ]);
//    }
}
