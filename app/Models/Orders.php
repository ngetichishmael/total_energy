<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
