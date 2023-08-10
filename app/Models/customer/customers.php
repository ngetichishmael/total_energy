<?php

namespace App\Models\customer;

use App\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class customers extends Model
{
   protected $table = 'customers';
   protected $guarded = [];

   /**
    * Get the Area that owns the customers
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Area(): BelongsTo
   {
      return $this->belongsTo(Area::class, 'route_code', 'id');
   }

   public function Region(): BelongsTo
   {
       return $this->belongsTo(Region::class, 'route_code', 'id');
   }
   /**
    * Get the Creator associated with the customers
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function Creator(): HasOne
   {
       return $this->hasOne(User::class, 'id', 'created_by');
   }
   /**
    * Get all of the Orders for the customers
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function Orders(): HasMany
   {
       return $this->hasMany(Orders::class, 'id', 'customerID');
   }
}
