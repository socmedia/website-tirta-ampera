<?php

namespace Modules\Core\Traits\Scopes;

use \Illuminate\Database\Eloquent\Builder;

trait PermissionScopes
{
    /**
     * Scope a query to search for permissions by name or guard name.
     * If a search term is provided, filter the permissions accordingly.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  object $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->when($keyword, function ($query) use ($keyword) {
            return $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('guard_name', 'like', '%' . $keyword . '%');
        });
    }
}
