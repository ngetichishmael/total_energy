<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Delivery extends Model
{
   protected $table = 'delivery';
   protected $guarded = [""];

   public function scopeSearch($query, $term)
   {
      $term = "%$term%";
      $query->where(function ($query) use ($term) {
         $query->where('customer_name', 'like', $term)
            ->orWhere('name', 'like', $term)
            ->orWhere('order_code', 'like', $term);
      });
   }
   /**
    * Get all of the OrderItems for the Delivery
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function OrderItems(): HasMany
   {
      return $this->hasMany(Order_items::class, 'order_code', 'order_code');
   }
   /**
    * Get all of the DeliveryItems for the Delivery
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function DeliveryItems(): HasMany
   {
      return $this->hasMany(Delivery_items::class, 'delivery_code', 'delivery_code');
   }
   /**
    * Get the Customer that owns the Delivery
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Customer(): BelongsTo
   {
      return $this->belongsTo(customers::class, 'customer', 'id');
   }
   /**
    * Get the User that owns the Delivery
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function User(): BelongsTo
   {
      return $this->belongsTo(User::class, 'allocated', 'user_code');
   }
   /**
    * Get the Order associated with the Delivery
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function Order(): HasOne
   {
      return $this->hasOne(Orders::class, 'order_code', 'order_code');
   }
}
