<?php

namespace Modules\Common\Traits\Scopes;

use \Illuminate\Database\Eloquent\Builder;

trait CategoryScopes
{
    /**
     * Scope a query to include only active categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope a query to include only inactive categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotActive($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Scope a query to include only featured categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    /**
     * Scope a query to include only non-featured categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotFeatured($query)
    {
        return $query->where('featured', 0);
    }

    /**
     * Scope a query to filter categories by group.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $group
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroup($query, $group)
    {
        return $query->with('childs')->where('group', $group);
    }

    /**
     * Scope a query to get the last category position for parents.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetParentLastPosition($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope a query to get the last category position for children.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  int|string $parent
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetChildLastPosition($query, $parent)
    {
        return $query->where('parent_id', $parent);
    }

    /**
     * Scope a query to search categories by name or description (directly from columns).
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->when($keyword, function ($query, $keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        });
    }
}
