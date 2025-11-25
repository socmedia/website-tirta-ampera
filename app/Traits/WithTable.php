<?php

namespace App\Traits;

trait WithTable
{
    /**
     * String properties
     *
     * @var string
     */
    public ?string $sort = 'created_at';
    public ?string $order = 'desc';
    public ?string $search = '';
    public ?string $destroyId;
    public ?string $action = 'destroy';

    /**
     * Integer properties
     *
     * @var int
     */
    public ?int $perPage = 10;

    /**
     * Bulk check id
     *
     * @var array
     */
    public ?array $checks = [];

    /**
     * Check all items
     *
     * @var bool
     */
    public bool $checkAll = false;

    /**
     * Livewire event listener for the Table Component to handle sorting order.
     *
     * @var string
     */
    const TABLE_SORT_ORDER = 'sortOrder';

    /**
     * Livewire event listener for the Table Component to handle items per page.
     *
     * @var string
     */
    const CHANGE_PER_PAGE = 'changePerPage';

    /**
     * Livewire event listener for bulk check actions.
     *
     * @var string
     */
    const BULK_CHECK = 'bulkCheck';

    /**
     * Handles the sorting order when the table header is clicked.
     *
     * @param  string $sort The column to sort by.
     * @return void
     */
    public function sortOrder(string $sort)
    {
        $this->resetPage();
        $this->sort = $sort;

        // Toggle the sorting order between ascending and descending
        $this->order = ($this->order === 'asc') ? 'desc' : 'asc';
    }

    /**
     * Updates the number of items displayed per page.
     *
     * @param  int $perPage The number of items to display per page.
     * @return void
     */
    public function changePerPage(int $perPage)
    {
        $this->per_page = $perPage;
    }

    /**
     * Handles checking/unchecking all rows in the table.
     *
     * @return void
     */
    public function updatedCheckAll($value)
    {
        $this->checks = $this->handleListing()->pluck('id')->mapWithKeys(fn($id) => [$id => $value])->toArray();
    }
}
