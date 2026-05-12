<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtSessionAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->session()->get('jwt_token');

        if (! $token) {
            return redirect()->route('login')->withErrors([
                'email' => 'Please login to access the admin dashboard.',
            ]);
        }

        try {
            $user = JWTAuth::setToken($token)->authenticate();
        } catch (JWTException) {
            $this->clearSession($request);

            return redirect()->route('login')->withErrors([
                'email' => 'Your session has expired. Please login again.',
            ]);
        }

        if (! $user) {
            $this->clearSession($request);

            return redirect()->route('login')->withErrors([
                'email' => 'Your session is invalid. Please login again.',
            ]);
        }

        Auth::login($user);

        return $next($request);
    }

    private function clearSession(Request $request): void
    {
        Auth::logout();
        $request->session()->forget('jwt_token');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
