<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class order_payments extends Model
{
    protected $table = 'order_payments';
    protected $guarded = [""];
    /**
     * Get the Order that owns the order_payments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Order(): BelongsTo
    {
        return $this->belongsTo(Orders::class, 'order_code', 'order_id');
    }
    /**
     * Get the user that owns the order_payments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
