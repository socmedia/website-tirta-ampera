<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect if already authenticated
                return match ($guard) {
                    'web' => redirect()->route('panel.web.index'),
                    'customer' => redirect()->route('customer.index'),
                    'vendor' => redirect()->route('vendor.index'),
                    default => redirect()->route('panel.web.index'),
                };
            }
        }

        return $next($request);
    }
}
