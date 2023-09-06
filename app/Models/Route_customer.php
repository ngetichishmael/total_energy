<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Route_customer extends Model
{
    protected $table = 'route_customer';

    /**
     * Get the Customer that owns the Route_customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Customer(): BelongsTo
    {
        return $this->belongsTo(customers::class, 'customerID', 'id');
    }
}
