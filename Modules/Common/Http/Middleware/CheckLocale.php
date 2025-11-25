<?php

namespace Modules\Common\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CheckLocale
{
    /**
     * Handle an incoming request and set the locale to 'id' for all routes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        App::setLocale('id');
        session(['locale' => 'id']);

        return $next($request);
    }
}
