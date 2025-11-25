<?php

namespace Modules\Common\Observers;

use Illuminate\Support\Facades\Artisan;
use Modules\Common\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        if (app()->environment('production')) {
            Artisan::call('sitemap:generate');
        }
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        if (app()->environment('production')) {
            Artisan::call('sitemap:generate');
        }
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        if (app()->environment('production')) {
            Artisan::call('sitemap:generate');
        }
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        if (app()->environment('production')) {
            Artisan::call('sitemap:generate');
        }
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        if (app()->environment('production')) {
            Artisan::call('sitemap:generate');
        }
    }
}
