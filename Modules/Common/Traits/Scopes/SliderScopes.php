<?php

namespace Modules\Common\Traits\Scopes;

use \Illuminate\Database\Eloquent\Builder;

trait SliderScopes
{
    /**
     * Scope a query to search in the Slider Table by name or description.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
        });
    }

    /**
     * Scope a query to filter banners by their active status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $isShow
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsShow($query, $isShow)
    {
        return $query->when($isShow, function ($query, $isShow) {
            return $query->where('status', $isShow === 'true' ? 1 : 0);
        });
    }
}
