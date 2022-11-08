<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Orders extends Model
{
    Protected $table = 'orders';

    Protected $guarded =[];

    public function scopeSearch($query, $term) {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('customer_name', 'like', $term);
        });
    }
    /**
     * Get the OrderItem associated with the Orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function OrderItem(): HasOne
    {
        return $this->hasOne(Order_items::class, 'order_code', 'order_code');
    }
    /**
     * Get the User that owns the Orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'user_code');
    }
    /**
     * Get the Customer that owns the Orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Customer(): BelongsTo
    {
        return $this->belongsTo(customers::class, 'customerID', 'id');
    }
}
