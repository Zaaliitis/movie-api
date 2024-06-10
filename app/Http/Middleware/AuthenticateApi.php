<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApi
{
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader === null) {
            return $this->unauthorized();
        }

        if (!$this->isValidAuthorizationHeader((string)$authorizationHeader)) {
            return $this->unauthorized();
        }

        list($username, $password) = $this->extractCredentials((string)$authorizationHeader);

        if (!$this->isValidCredentials($username, $password)) {
            return $this->unauthorized();
        }

        return $next($request);
    }

    private function isValidAuthorizationHeader(string $authorizationHeader): bool
    {
        return preg_match('/^Basic\s+[a-zA-Z0-9+\/=]+$/', $authorizationHeader) == 1;
    }
    /**
     * @return array{0: string|null, 1: string|null}
     */
    private function extractCredentials(string $authorizationHeader): array
    {
        $encodedCredentials = substr($authorizationHeader, 6);
        $decodedCredentials = base64_decode($encodedCredentials);

        if (!$decodedCredentials || !str_contains($decodedCredentials, ':')) {
            return [null, null];
        }

        return [
            '0' => explode(':', $decodedCredentials, 2)[0],
            '1' => explode(':', $decodedCredentials, 2)[1]
        ];
    }

    private function isValidCredentials(?string $username, ?string $password): bool
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
