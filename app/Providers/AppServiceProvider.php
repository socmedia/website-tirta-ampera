<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        URL::macro('livewireCurrent', function () {
            if (request()->route()->named('livewire.update')) {
                $previousUrl = url()->previous();
                $route = request()->route();
                $previousRequest = request()->create($previousUrl);
                $previousRoute = app('router')->getRoutes()->match($previousRequest);

                return (object) [
                    'url' => $previousUrl,
                    'name' => $previousRoute->getName(),
                    'route' => $previousRoute,
                    'query' => $previousRequest->query()
                ];
            } else {
                $route = request()->route();

                return (object) [
                    'url' => request()->url(),
                    'name' => $route->getName(),
                    'route' => $route,
                    'query' => request()->query()
                ];
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}