<?php

namespace App\Traits\Scopes;

trait Sortable
{
    /**
     * Scope a query to sort results based on a specified column and order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $sort Column to sort by
     * @param  string $order Sort direction (asc/desc)
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort($query, $sort, $order)
    {
        $fillableColumns = $query->getModel()->getFillable();

        // Check if the sort column and order are valid
        if (
            in_array($sort, $fillableColumns) &&
            in_array($order, ['asc', 'desc'])
        ) {
            return $query->orderBy($sort, $order);
        }

        // Return the original query if the validation fails
        return $query;
    }
}
