<?php

namespace Modules\Common\Traits\Scopes;

use Modules\Common\Models\Category;

trait BelongsToCategory
{
    /**
     * Get the associated category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Scope a query to filter by category ID or slug.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategory($query, $keyword = null)
    {
        return $query->when($keyword, function ($query) use ($keyword) {
            $query->where('category_id', $keyword)
                ->orWhereHas('category', function ($relation) use ($keyword) {
                    $relation->where('slug', $keyword);
                });
        });
    }
}