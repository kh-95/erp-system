<?php

namespace App\Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Role;

class CustomRoleMiddleware
{
    public function handle($request, Closure $next, $role, $guard = null)
    {
        $authGuard = Auth::guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        foreach ($roles as $role) {
            $roleRecord = Role::where('name', $role)->first();
            if ($authGuard->user()->hasRole($role) && $roleRecord && !(bool)$roleRecord->deactivated_at) {
                return $next($request);
            }
        }

        throw UnauthorizedException::forRoles($roles);
    }
}
