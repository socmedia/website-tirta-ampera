<?php

namespace Modules\Front\Livewire\Ui\Partials;

use Livewire\Component;
use Illuminate\Support\Collection;
use Livewire\WithPagination;
use Modules\Common\Services\PostService;
use Modules\Common\Services\ProductService;
use Modules\Common\Services\StoreService;

class Search extends Component
{
    use WithPagination;

    /**
     * The search keyword entered by the user.
     *
     * @var string
     */
    public string $keyword = '';

    /**
     * The current selected tab: 'news', 'product', or 'store'.
     *
     * @var string
     */
    public string $tab = 'news';

    /**
     * The number of results per page.
     *
     * @var int
     */
    public int $perPage = 5;

    /**
     * Available tabs for searching.
     *
     * @var array
     */
    public array $tabs = [
        'news'    => 'front::navbar.news',
    ];

    /**
     * Indicates if there are more pages of results.
     *
     * @var bool
     */
    public bool $hasMorePages = false;

    /**
     * Set the active tab.
     *
     * @param string $tab
     * @return void
     */
    public function setTab(string $tab): void
    {
        if (array_key_exists($tab, $this->tabs)) {
            $this->tab = $tab;
            $this->reset('perPage', 'keyword');
        }
    }

    /**
     * Perform the search based on the current tab and keyword.
     *
     * @return \Illuminate\Contracts\Pagination\Paginator|\Illuminate\Support\Collection
     */
    public function search()
    {
        $keyword = trim($this->keyword);

        if ($keyword === '') {
            $this->hasMorePages = false;
            return collect();
        }

        $results = null;

        switch ($this->tab) {
            case 'news':
                $results = (new PostService)->publicSearch($keyword, $this->perPage);
                break;
            default:
                $results = collect();
        }

        // Set hasMorePages if paginator, otherwise false
        if (method_exists($results, 'hasMorePages')) {
            $this->hasMorePages = $results->hasMorePages();
        } else {
            $this->hasMorePages = false;
        }

        return $results;
    }

    /**
     * Load more results by increasing perPage and re-running the search.
     *
     * @return void
     */
    public function loadMore(): void
    {
        $this->perPage += 5;
    }

    /**
     * Close the search modal and reset product/result state.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('perPage', 'keyword');
        $this->js('showSearch = false');
    }

    public function render()
    {
        return view('front::livewire.ui.partials.search', [
            'results' => $this->search(),
        ]);
    }
}
