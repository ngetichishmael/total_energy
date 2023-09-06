<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class allocations extends Model
{
   protected $table = 'inventory_allocations';
   protected $guarded = [""];

   public function user(): BelongsTo
   {
      return $this->belongsTo(User::class, 'sales_person', 'user_code');
   }
}
