<?php

namespace Modules\Core\Models;

use App\Traits\Scopes\Sortable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Scopes\RoleScopes;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasPermissions;
use Modules\Core\Traits\Adapters\RoleAdapters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\RefreshesPermissionCache;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
// Model Role
{
    use HasFactory;
    use Sortable;
    use RoleAdapters;
    use RoleScopes;
    use HasPermissions;
    use RefreshesPermissionCache;

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

    /**
     * A model may have multiple direct permissions.
     */
    public function permissions(): BelongsToMany
    {
        $relation = $this->morphToMany(
            Permission::class,
            'model',
            config('permission.table_names.model_has_permissions'),
            config('permission.column_names.model_morph_key'),
            app(PermissionRegistrar::class)->pivotPermission
        );

        if (! app(PermissionRegistrar::class)->teams) {
            return $relation;
        }

        $teamsKey = app(PermissionRegistrar::class)->teamsKey;
        $relation->withPivot($teamsKey);

        return $relation->wherePivot($teamsKey, getPermissionsTeamId());
    }
}