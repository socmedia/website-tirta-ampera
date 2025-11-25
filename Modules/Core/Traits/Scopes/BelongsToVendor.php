<?php

namespace Modules\Core\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Models\Vendor;

trait BelongsToVendor
{
    /**
     * Boot the trait to add a global scope for vendor filtering.
     *
     * @return void
     */
    protected static function bootBelongsToVendor()
    {
        // Automatically filter the model by vendor_id if a vendor is logged in
        static::addGlobalScope('vendor', function (Builder $builder) {
            $vendor = auth('vendor')->user();
            $builder->when($vendor, function ($query) use ($vendor) {
                return $query->where('vendor_id', $vendor->id);
            });
        });
    }

    /**
     * Define the relationship with the Vendor model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    /**
     * Scope a query to filter by vendor_id.
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $request
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeVendor($query, $request)
    {
        // return $query->when(isset($request->vendor), function ($query) use ($request) {
        //     $query->where('vendor_id', $request->vendor);
        // });
    }
}
