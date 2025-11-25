<?php

namespace Modules\Core\Traits\Scopes;

use \Illuminate\Database\Eloquent\Builder;

trait VendorScopes
{
    /**
     * Scope a query to search for vendors by fullname, email, or other attributes.
     * If a search term is provided, filter the vendors accordingly.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  object $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->when($keyword, function ($vendor) use ($keyword) {
            return $vendor->where('fullname', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->orWhereHas('vendorSettings', function ($relation) use ($keyword) {
                    $relation->where('about', 'like', '%' . $keyword . '%');
                });
        });
    }
}
