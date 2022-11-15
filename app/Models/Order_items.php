<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order_items extends Model
{
    protected $table = 'order_items';
    protected $guarded =[];

    /**
     * Get the Order that owns the Order_items
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Order(): BelongsTo
    {
        return $this->belongsTo(Orders::class, 'order_code', 'order_code');
    }
}
