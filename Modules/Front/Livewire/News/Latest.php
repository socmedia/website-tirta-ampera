<?php

namespace Modules\Front\Livewire\News;

use Livewire\Component;
use Modules\Common\Services\PostService;

class Latest extends Component
{
    public function render()
    {
        return view('front::livewire.news.latest', [
            'news' => (new PostService)->publicPosts([
                'per_page' => 4
            ]),
        ]);
    }
}