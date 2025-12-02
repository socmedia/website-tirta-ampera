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
     * Get the related news data.
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    protected function getRelatedNews()
    {
        $filters = [
            'per_page' => 4,
        ];

        // Prefer category as primary relation, fallback to tags if present
        if (!empty($this->category)) {
            $filters['category_id'] = $this->category;
        } elseif (!empty($this->tags)) {
            $filters['tags'] = $this->tags;
        }

        if (!empty($this->exceptId)) {
            $filters['except_id'] = $this->exceptId;
        }

        $filters['sort'] = 'published_at';
        $filters['order'] = 'desc';

        return (new PostService)->publicPosts($filters);
    }

    /**
     * Render the related news view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('front::livewire.news.related', [
            'news' => $this->getRelatedNews(),
        ]);
    }
}
