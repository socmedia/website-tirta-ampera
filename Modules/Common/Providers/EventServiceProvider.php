<?php

namespace Modules\Common\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Common\Models\AppSetting;
use Modules\Common\Models\Content;
use Modules\Common\Models\Post;
use Modules\Common\Observers\AppSettingObserver;
use Modules\Common\Observers\ContentObserver;
use Modules\Common\Observers\PostObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();

        AppSetting::observe(AppSettingObserver::class);
        Content::observe(ContentObserver::class);
        Post::observe(PostObserver::class);
    }
}
