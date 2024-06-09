<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApi
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasHeader('Authorization')) {
            return $this->unauthorized();
        }

        $authorizationHeader = $request->header('Authorization');
        if (!$this->isValidAuthorizationHeader($authorizationHeader)) {
            return $this->unauthorized();
        }

        list($username, $password) = $this->extractCredentials($authorizationHeader);

        if (!$this->isValidCredentials($username, $password)) {
            return $this->unauthorized();
        }

        return $next($request);
    }

    private function isValidAuthorizationHeader($authorizationHeader): bool
    {
        return preg_match('/^Basic\s+[a-zA-Z0-9+\/=]+$/', $authorizationHeader) === 1;
    }

    private function extractCredentials($authorizationHeader): array
    {
        $encodedCredentials = substr($authorizationHeader, 6);
        $decodedCredentials = base64_decode($encodedCredentials);
        if ($decodedCredentials === false || !strpos($decodedCredentials, ':')) {
            return [null, null];
        }
        return explode(':', $decodedCredentials, 2);
    }

    private function isValidCredentials($username, $password): bool
    {
        $validUsername = env('API_USERNAME');
        $validPassword = env('API_PASSWORD');
        return $username === $validUsername && $password === $validPassword;
    }

    private function unauthorized(): Response
    {
        return response()->json(['message' => 'Unauthorized'], 401, [
            'WWW-Authenticate' => 'Basic realm="API Authentication"',
        ]);
    }
}
