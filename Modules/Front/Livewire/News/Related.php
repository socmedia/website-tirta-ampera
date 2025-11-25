<?php

namespace Modules\Front\Livewire\News;

use Livewire\Component;
use Modules\Common\Services\PostService;

class Related extends Component
{
    /**
     * The tag to filter related news.
     *
     * @var string|null
     */
    public ?string $tags = null;

    /**
     * The category to filter related news.
     *
     * @var string|null
     */
    public ?string $category = null;

    /**
     * The ID to exclude from related news.
     *
     * @var int|string|null
     */
    public $exceptId = null;

    /**
     * Mount the component with the given tags, category, and except id.
     *
     * @param string|null $tags
     * @param string|null $category
     * @param int|string|null $exceptId
     * @return void
     */
    public function mount(?string $tags = null, ?string $category = null, $exceptId = null)
    {
        $this->tags = $tags;
        $this->category = $category;
        $this->exceptId = $exceptId;
    }

    /**
     * Render the related news view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $filters = [
            'category_id' => $this->category,
            'tags' => $this->tags,
            'per_page' => 4,
        ];

        if (!empty($this->exceptId)) {
            $filters['except_id'] = $this->exceptId;
        }

        return view('front::livewire.news.related', [
            'news' => (new PostService)->publicPosts($filters),
        ]);
    }
}
