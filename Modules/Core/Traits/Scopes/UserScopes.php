<?php

namespace Modules\Core\Traits\Scopes;

use \Illuminate\Database\Eloquent\Builder;

trait UserScopes
{
    /**
     * Scope a query to search for users by name, email, or role.
     * If a search term is provided, filter the users accordingly.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  object $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->when($keyword, function ($user) use ($keyword) {
            return $user->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->orWhereHas('roles', function ($relation) use ($keyword) {
                    $relation->where('name', 'like', '%' . $keyword . '%');
                });
        });
    }
}
