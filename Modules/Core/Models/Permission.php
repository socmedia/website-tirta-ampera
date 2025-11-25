<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes\Sortable;
use Modules\Core\Traits\Adapters\PermissionAdapters;
use Modules\Core\Traits\Scopes\PermissionScopes;

class Permission extends Model
{
    use HasFactory;
    use Sortable;
    use PermissionAdapters;
    use PermissionScopes;

    /**
     * Define fillable columns.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at',
    ];
}
