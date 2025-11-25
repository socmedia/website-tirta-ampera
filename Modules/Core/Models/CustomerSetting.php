<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Scopes\BelongsToCustomer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Adapters\CustomerSettingAdapters;

class CustomerSetting extends Model
{
    use HasFactory;
    use BelongsToCustomer;
    use CustomerSettingAdapters;

    /**
     * Define fillable column in the post table
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'setting_key',
        'setting_value',
        'type',
        'created_at',
        'updated_at',
    ];
}
