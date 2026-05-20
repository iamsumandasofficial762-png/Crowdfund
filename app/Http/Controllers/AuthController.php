<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('jwt_token') && Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {
            $token = JWTAuth::attempt($credentials);
        } catch (JWTException) {
            return back()
                ->withInput($request->only('email') + ['auth_mode' => 'login'])
                ->withErrors(['email' => 'Unable to create login token. Please try again.']);
        }

        if (! $token) {
            return back()
                ->withInput($request->only('email') + ['auth_mode' => 'login'])
                ->withErrors(['email' => 'The provided credentials do not match our records.']);
        }

        $user = JWTAuth::setToken($token)->authenticate()?->load('role.permissions');

        if (! $user || ! $user->isActive()) {
            JWTAuth::setToken($token)->invalidate();

            return back()
                ->withInput($request->only('email') + ['auth_mode' => 'login'])
                ->withErrors(['email' => 'Your account is currently on hold. Please contact the administrator.']);
        }

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('jwt_token', $token);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function register(Request $request)
    {
        abort(404);
    }

    public function logout(Request $request)
    {
        $token = $request->session()->get('jwt_token');

        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate();
            } catch (JWTException) {
                //
            }
        }

        Auth::logout();
        $request->session()->forget('jwt_token');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'You have been logged out successfully.');
    }
}
