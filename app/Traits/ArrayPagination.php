<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

trait ArrayPagination
{
    /**
     * Paginate a given array of items.
     *
     * @param array $items The items to paginate.
     * @param int $per_page The number of items per page.
     * @param int|null $page The current page number.
     * @param array $options Additional options for pagination.
     * @return LengthAwarePaginator The paginator instance.
     */
    public function paginate(array $items, $per_page = 10, $page = null, array $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $per_page), $items->count(), $per_page, $page, $options);
    }
}
