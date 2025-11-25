<?php

namespace Modules\Core\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Models\User;

trait BelongsToUser
{
    protected static function bootBelongsToUser()
    {
        // Automatically filter based on branch_id if the user has one
        // static::addGlobalScope('filterBranch', function (Builder $builder) {
        //     if ($user = auth()->user()) {
        //         $builder->where('branch_id', $user->branch_id);
        //     }
        // });
    }

    /**
     * Define the relationship with the User model (user_id).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define the relationship with the User model for seen_by.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viewer()
    {
        return $this->belongsTo(User::class, 'seen_by');
    }

    /**
     * Define the relationship with the User model for created_by (author).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to filter by user_id or slug.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUser($query, $request)
    {
        // return $query->when(isset($request->user), function ($query) use ($request) {
        //     $query->where('user_id', $request->user)
        //         ->orWhereHas('user', function ($relation) use ($request) {
        //             $relation->where('slug', $request->user);
        //         });
        // });
    }
}