<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdersTarget extends Model
{
    use HasFactory;
    protected $table ='orders_targets';
    protected $guarded= [];
     /**
     * Get the User that owns the LeadsTargets
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'user_code');
    }
}
