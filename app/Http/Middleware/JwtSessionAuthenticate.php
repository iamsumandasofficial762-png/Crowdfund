<?php

namespace App\Http\Middleware;

use App\Support\AdminPermissions;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
            $user = JWTAuth::setToken($token)->authenticate()?->load('role.permissions');
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

        if (! $user->isActive()) {
            $this->clearSession($request);

            return redirect()->route('login')->withErrors([
                'email' => 'Your account is currently on hold. Please contact the administrator.',
            ]);
        }

        Auth::login($user);

        $requiredPermission = $this->requiredPermission($request);

        if ($requiredPermission && ! $user->hasPermission($requiredPermission)) {
            abort(403, 'Unauthorized. You do not have permission to access this admin page.');
        }

        if ($this->isDeleteRoute($request) && ! $user->hasPermission(AdminPermissions::RECORDS_DELETE)) {
            abort(403, 'Unauthorized. You do not have permission to delete records.');
        }

        return $next($request);
    }

    private function clearSession(Request $request): void
    {
        Auth::logout();
        $request->session()->forget('jwt_token');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    private function requiredPermission(Request $request): ?string
    {
        $routeName = $request->route()?->getName();

        if (! $routeName) {
            return null;
        }

        foreach (AdminPermissions::routeMap() as $pattern => $permission) {
            if (Str::is($pattern, $routeName)) {
                return $permission;
            }
        }

        return null;
    }

    private function isDeleteRoute(Request $request): bool
    {
        $routeName = $request->route()?->getName() ?? '';

        if (Str::is('admin.users.destroy', $routeName)) {
            return false;
        }

        return $request->isMethod('DELETE')
            || Str::is('*.destroy', $routeName)
            || Str::contains($routeName, '.delete');
    }
}
