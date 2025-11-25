<?php

namespace Modules\Core\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Models\Customer;

trait BelongsToCustomer
{
    /**
     * Boot the trait to add a global scope for customer filtering.
     *
     * @return void
     */
    protected static function bootBelongsToCustomer()
    {
        // Automatically filter the model by customer_id if a customer is logged in
        static::addGlobalScope('customer', function (Builder $builder) {
            $customer = auth('customer')->user();
            $builder->when($customer, function ($query) use ($customer) {
                return $query->where('customer_id', $customer->id);
            });
        });
    }

    /**
     * Define the relationship with the Customer model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Scope a query to filter by customer_id or email.
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $request
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeCustomer($query, $request)
    {
        // return $query->when(isset($request->customer), function ($query) use ($request) {
        //     $query->where('customer_id', $request->customer)
        //         ->orWhereHas('customer', function ($relation) use ($request) {
        //             $relation->where('id', $request->customer)
        //                 ->orWhere('email', $request->customer);
        //         });
        // });
    }
}
