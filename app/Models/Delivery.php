<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    Protected $table = 'delivery';

    public function scopeSearch($query, $term) {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('customer_name', 'like', $term)
            ->orWhere('name', 'like', $term)
            ->orWhere('order_code', 'like', $term);
        });
    }
}
