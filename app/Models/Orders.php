<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
