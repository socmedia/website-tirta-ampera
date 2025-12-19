<?php

namespace Modules\Common\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Common\Models\Post;
use Illuminate\Support\Facades\Session;
use Modules\Common\Services\PostService;
use Carbon\Carbon;

class ViewPost
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Attempt to get the post from the route
        $slug = $request->slug;

        if ($slug) {
            $post = (new PostService())->findPublicBySlug($slug);
        }

        if ($post instanceof Post) {
            $sessionKey = 'viewed_posts_with_time';

            // Use session to track viewed posts with timestamp
            $viewed = Session::get($sessionKey, []);

            $now = Carbon::now();

            // Check if post has been viewed and when
            if (
                isset($viewed[$post->id]) &&
                isset($viewed[$post->id]['last_viewed']) &&
                $now->diffInMinutes(Carbon::parse($viewed[$post->id]['last_viewed'])) < 60
            ) {
                // Last increment was less than one hour ago, don't increment again
                return $next($request);
            }

            // Either post not viewed before or last viewed more than 1 hour ago, increment views
            $post->increment('number_of_views');
            $viewed[$post->id]['last_viewed'] = $now->toDateTimeString();
            Session::put($sessionKey, $viewed);
        }

        return $next($request);
    }
}
