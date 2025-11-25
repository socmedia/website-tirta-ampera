<?php

namespace Modules\Common\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ContactMessageScopes
{
    /**
     * Scope a query to search contact messages by name, email, subject, or message.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, ?string $keyword)
    {
        return $query->when($keyword, function ($q) use ($keyword) {
            $q->where(function ($q2) use ($keyword) {
                $q2->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('whatsapp_number', 'like', "%{$keyword}%")
                    ->orWhere('topic', 'like', "%{$keyword}%")
                    ->orWhere('subject', 'like', "%{$keyword}%")
                    ->orWhere('message', 'like', "%{$keyword}%");
            });
        });
    }

    /**
     * Scope a query to only include seen contact messages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSeen(Builder $query)
    {
        return $query->whereNotNull('seen_at');
    }

    /**
     * Scope a query to only include unseen contact messages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnseen(Builder $query)
    {
        return $query->whereNull('seen_at');
    }
}
