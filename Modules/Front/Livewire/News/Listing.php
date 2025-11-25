<?php

namespace Modules\Front\Livewire\News;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Common\Services\CategoryService;
use Modules\Common\Services\PostService;

class Listing extends Component
{
    use WithPagination;

    /**
     * The search keyword.
     *
     * @var string|null
     */
    public $search;

    /**
     * The sort field.
     *
     * @var string|null
     */
    public $sortOption;

    /**
     * The sort order.
     *
     * @var string|null
     */
    public $order;

    /**
     * The selected categories.
     *
     * @var array
     */
    public $selectedCategories = [];

    /**
     * The selected tag for filtering.
     *
     * @var string|null
     */
    public $tag;

    /**
     * The number of news per page.
     *
     * @var int
     */
    public $perPage = 6;

    /**
     * Query string properties for Livewire.
     *
     * @var array
     */
    protected $queryString = [
        'search',
        'tag',
    ];

    /**
     * Listen for any property update and handle accordingly.
     *
     * @param string $property
     * @param mixed $value
     * @return void
     */
    public function updated($property, $value)
    {
        if (in_array($property, ['search', 'selectedCategories', 'sortOption', 'tag'])) {
            $this->resetPage();
        }
    }

    /**
     * Handle the listing of news with search and pagination.
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function handleListing()
    {
        $filters = [
            'keyword' => $this->search ?? null,
            'categories' => $this->selectedCategories,
            'tag' => $this->tag ?? null,
            // Remove locale for single language setup
            'sort_option' => $this->sortOption,
            'per_page' => $this->perPage,
        ];

        return (new PostService)->publicPosts($filters, true);
    }

    /**
     * Reset all filters to their default values.
     */
    public function resetFilters()
    {
        $this->reset('search', 'selectedCategories', 'perPage', 'sortOption', 'tag');
        $this->resetPage();
    }

    public function render()
    {
        return view('front::livewire.news.listing', [
            'news' => $this->handleListing(),
            'categories' => (new CategoryService)->getPublicCategoriesByGroup('posts'),
            'hasActiveFilter' => !empty($this->search) || !empty($this->selectedCategories) || ($this->sortOption ?? 'newest') !== 'newest' || !empty($this->tag)
        ]);
    }
}
