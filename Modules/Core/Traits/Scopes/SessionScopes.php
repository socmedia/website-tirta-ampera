<?php

namespace Modules\Core\Traits\Scopes;

use \Illuminate\Database\Eloquent\Builder;

trait SessionScopes
{
    /**
     * Scope a query to search for sessions by name.
     * If a search term is provided, filter the sessions accordingly.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  object $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->when($keyword, function ($query) use ($keyword) {
            return $query->where('session_name', 'like', '%' . $keyword . '%');
        });
    }
}
