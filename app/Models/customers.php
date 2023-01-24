<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class customers extends Model
{
   protected $table = 'customers';
   /**
    * Get the Region that owns the customers
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Region(): BelongsTo
   {
      return $this->belongsTo(Region::class, 'route_code', 'primary_key');
   }
   /**
    * Get the user that owns the customers
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function user(): BelongsTo
   {
      return $this->belongsTo(User::class, 'foreign_key', 'other_key');
   }
}