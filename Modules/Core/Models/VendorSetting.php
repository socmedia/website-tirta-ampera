<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Scopes\BelongsToVendor;
use Modules\Core\Traits\Adapters\VendorSettingAdapters;

class VendorSetting extends Model
{
    use HasFactory;
    use BelongsToVendor;
    use VendorSettingAdapters;

    /**
     * Define fillable column in the vendor settings table
     *
     * @var array
     */
    protected $fillable = [
        'vendor_id',
        'setting_key',
        'setting_value',
        'type',
        'created_at',
        'updated_at',
    ];
}
