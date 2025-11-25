<?php

namespace Modules\Common\Models;

use App\Traits\Scopes\Sortable;
use Illuminate\Database\Eloquent\Model;
use Modules\Common\Traits\Scopes\ContentScopes;
use Modules\Common\Traits\Adapters\ContentAdapters;

class Content extends Model
{
    use Sortable;
    use ContentAdapters;
    use ContentScopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
        'page',
        'section',
        'key',
        'type',
        'input_type',
        'meta',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
    ];
}
