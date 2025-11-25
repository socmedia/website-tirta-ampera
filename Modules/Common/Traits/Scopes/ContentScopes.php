<?php

namespace Modules\Common\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ContentScopes
{
    /**
     * Scope a query to group by the page field.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroupByPage($query)
    {
        return $query->select('page')->groupBy('page');
    }

    /**
     * Scope a query to filter by page.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|null $page
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePage($query, ?string $page)
    {
        return $query->when($page, function ($query) use ($page) {
            return $query->where('page', $page);
        });
    }

    /**
     * Scope a query to search in the contents table (no translations).
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query) use ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('value', 'like', '%' . $keyword . '%')
                    ->orWhere('page', 'like', '%' . $keyword . '%')
                    ->orWhere('section', 'like', '%' . $keyword . '%')
                    ->orWhere('key', 'like', '%' . $keyword . '%')
                    ->orWhere('type', 'like', '%' . $keyword . '%')
                    ->orWhere('input_type', 'like', '%' . $keyword . '%')
                    ->orWhereJsonContains('meta', $keyword);
            });
        });
    }
}
