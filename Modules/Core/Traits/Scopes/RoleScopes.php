<?php

namespace Modules\Core\Traits\Scopes;

trait RoleScopes
{
    /**
     * Scope a query to search for roles by name.
     * If a search term is provided, filter the roles accordingly.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  object $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->when($keyword, function ($query) use ($keyword) {
            return $query->where('name', 'like', '%' . $keyword . '%');
        });
    }
}