<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HorizonBasicAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->shouldSkipAuthentication()) {
            if (! $this->authenticate($request)) {
                return response('Invalid Credentials.', Response::HTTP_UNAUTHORIZED)
                    ->header('WWW-Authenticate', 'Basic');
            }
        }

        return $next($request);
    }

    private function shouldSkipAuthentication(): bool
    {
        return in_array(config('app.env'), ['local', 'dev']);
    }

    private function authenticate(Request $request): bool
    {
        $username = $request->header('PHP_AUTH_USER');
        $password = $request->header('PHP_AUTH_PW');

        $expectedUsername = config('horizon.basic_auth.username');
        $expectedPassword = config('horizon.basic_auth.password');

        return $username === $expectedUsername && $password === $expectedPassword;
    }
}
