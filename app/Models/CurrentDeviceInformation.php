<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrentDeviceInformation extends Model
{
    use HasFactory;
    protected $table ="current_device_information";
    protected $guarded=[""];
    /**
     * Get the user that owns the CurrentDeviceInformation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'user_code');
    }
}