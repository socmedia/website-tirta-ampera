<?php

namespace Modules\Auth\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * --------------------------------------------------------------------------
     * Redirect Paths
     * --------------------------------------------------------------------------
     *
     * These constants define where users should be redirected after they log in,
     * based on their role or guard type.
     */
    public const HOME = '/';
    public const USER_DASHBOARD = '/panel';
    public const CUSTOMER_DASHBOARD = '/customer';
    public const VENDOR_DASHBOARD = '/vendor';

    /**
     * --------------------------------------------------------------------------
     * Module Namespace
     * --------------------------------------------------------------------------
     *
     * Defines the base namespace for this module's controllers.
     * This helps when generating URLs or resolving controller actions.
     */
    protected string $moduleNamespace = 'Modules\Auth\Http\Controllers';

    /**
     * --------------------------------------------------------------------------
     * Route Middleware
     * --------------------------------------------------------------------------
     *
     * Custom middleware for handling multi-guard authentication routing.
     * 'auth.module' dynamically determines the appropriate login route
     * based on the specified guard.
     */
    protected $routeMiddleware = [
        'auth.module' => \Modules\Auth\Http\Middleware\Authenticate::class,
        'auth.verified' => \Modules\Auth\Http\Middleware\EnsureEmailIsVerified::class,
    ];

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Auth', '/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Auth', '/Routes/api.php'));
    }
}
