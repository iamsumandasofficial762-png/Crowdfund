<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        Auth::login(JWTAuth::setToken($token)->authenticate());
        $request->session()->regenerate();
        $request->session()->put('jwt_token', $token);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException) {
            return back()
                ->withInput($request->only('name', 'email') + ['auth_mode' => 'register'])
                ->withErrors(['email' => 'Account created, but login token could not be generated. Please login.']);
        }

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('jwt_token', $token);

        return redirect()->route('admin.dashboard')->with('status', 'Account created successfully.');
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
