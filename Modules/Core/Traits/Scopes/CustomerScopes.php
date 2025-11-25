<?php

namespace Modules\Core\Traits\Scopes;

use \Illuminate\Database\Eloquent\Builder;

trait CustomerScopes
{
    /**
     * Scope a query to search for customers by fullname, email, or other attributes.
     * If a search term is provided, filter the customers accordingly.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  object $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->when($keyword, function ($customer) use ($keyword) {
            return $customer->where('fullname', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->orWhereHas('customerSettings', function ($relation) use ($keyword) {
                    $relation->where('about', 'like', '%' . $keyword . '%');
                });
        });
    }
}
