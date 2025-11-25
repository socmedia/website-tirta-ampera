<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * Redirects unauthenticated users to their guard-specific login routes.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $next($request);
            }
        }

        // Redirect based on guard type
        return match ($guard) {
            'web' => redirect()->route('auth.web.login'),
            'customer' => redirect()->route('auth.customer.login'),
            'vendor' => redirect()->route('auth.vendor.login'),
            default => redirect()->route('auth.web.login'),
        };
    }
}
