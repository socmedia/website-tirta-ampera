<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\App\Enums\Guards;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * Redirects unauthenticated or unverified users to the correct route.
     */
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        foreach (Guards::cases() as $guardEnum) {
            $guardName = $guardEnum->value;
            $user = $request->user($guardName);

            if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
                $route = $redirectToRoute ?: $guardEnum->verificationNoticeRoute();

                return $request->expectsJson()
                    ? abort(403, 'Your email address is not verified.')
                    : redirect()->guest(URL::route($route));
            }
        }

        return $next($request);
    }
}
