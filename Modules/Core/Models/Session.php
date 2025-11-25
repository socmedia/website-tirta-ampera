<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes\Sortable;
use Modules\Core\Traits\Adapters\SessionAdapters;
use Modules\Core\Traits\Scopes\BelongsToUser;
use Modules\Core\Traits\Scopes\SessionScopes;

class Session extends Model
{
    use HasFactory;
    use BelongsToUser;
    use SessionAdapters;
    use SessionScopes;
    use Sortable;

    /**
     * Define fillable columns
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];
}
