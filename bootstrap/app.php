<?php

use Illuminate\Foundation\Application;
use Fahlisaputra\Minify\Middleware\MinifyHtml;
use Modules\Core\Http\Middleware\SecureHeaders;
use Modules\Common\Http\Middleware\Localization;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.module' => \Modules\Auth\Http\Middleware\Authenticate::class,
            'guest' => \Modules\Auth\Http\Middleware\RedirectIfAuthenticated::class,
            'verified' => \Modules\Auth\Http\Middleware\EnsureEmailIsVerified::class,
            'post.view' => \Modules\Common\Http\Middleware\ViewPost::class,
        ]);

        $middleware->web(
            append: [
                Localization::class,
                SecureHeaders::class,
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, $request) {
            $env = app()->environment();
            $isLocal = $env === 'local';

            // ✅ Use Laravel's default exception renderer in local
            if ($isLocal) {
                return null; // Let Laravel handle it
            }

            // If request expects JSON, return JSON error response
            if ($request->expectsJson()) {
                $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
                return response()->json([
                    'message' => 'An error occurred.',
                    'exception' => null,
                ], $status);
            }

            // Determine route name prefix (if available)
            $isPanel = $request->routeIs('panel.*');

            // Determine status code
            $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

            try {
                $view = $isPanel
                    ? "panel::errors.{$status}"
                    : "front::errors.{$status}";


                if (view()->exists($view)) {
                    return response()->view($view, ['exception' => $e], $status);
                }
            } catch (\Throwable $viewException) {
                return response()->view('front::errors.500', ['exception' => $e], 500);
            }

            // Fallback to a basic 500 error page
            return response()->view('front::errors.500', ['exception' => $e], 500);
        });
    })

    ->create();

return $app;
