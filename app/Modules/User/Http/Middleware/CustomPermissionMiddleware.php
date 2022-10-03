<?php

namespace App\Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;

class CustomPermissionMiddleware
{
    public function handle($request, Closure $next, $permission, $guard = null)
    {
        
        $authGuard = app('auth')->guard($guard);
        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        foreach ($permissions as $permission) {
            $permissionRecord = Permission::where('name', $permission)->first();
            if ($authGuard->user()->can($permission) && $permissionRecord && !(bool)$permissionRecord->deactivated_at) {
                return $next($request);
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
