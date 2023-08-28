<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Route_sales extends Model
{
   protected $table = 'route_sales';

   public function user(): HasMany
   {
      return $this->hasMany(User::class, 'id', 'userID');
   }
}
