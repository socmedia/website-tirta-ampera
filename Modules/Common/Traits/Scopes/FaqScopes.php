<?php

namespace Modules\Common\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait FaqScopes
{
    /**
     * Scope a query to only include active FAQs.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope a query to only include inactive FAQs.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Scope a query to search FAQs by a given keyword. No translation, search directly in question and answer.
     *
     * @param  Builder $query
     * @param  string|null $keyword
     * @return Builder
     */
    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query) use ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('question', 'like', '%' . $keyword . '%')
                    ->orWhere('answer', 'like', '%' . $keyword . '%');
            });
        });
    }
}
