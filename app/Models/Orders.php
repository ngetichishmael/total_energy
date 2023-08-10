<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;
use App\Models\customers;
use App\Models\AssignedRegion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class Orders extends Model
{
   use Searchable;
   protected $table = 'orders';

   protected $guarded = [];
   protected $searchable = [
      'user.name',
      'Customer.customer_name',
      'order_type',
      'Customer.Region.name',
      'Customer.Region.Subregion.name',
      'Customer.Region.Subregion.area.name',
   ];
   /**
    * Get the OrderItem associated with the Orders
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */

    public function scopeFilterOrders($query)
    {
        $user = Auth::user();
    
        if (Auth::check() && $user->account_type != 'Admin') {
            $userRegionIds = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id');
    
            $userSubregionIds = Subregion::whereIn('region_id', $userRegionIds)->pluck('id');
    
            $userAreaIds = Area::whereIn('subregion_id', $userSubregionIds)->pluck('id');
    
            return $query->whereIn('customerID', function ($subquery) use ($userAreaIds) {
                $subquery->select('id')
                         ->from('customers')
                         ->whereIn('route_code', $userAreaIds);
            });
        }
    
        return $query;
    }
    
    
    
    
    

    public function newQuery()
    {
        if (Route::current() && in_array('web', Route::current()->middleware())) {
            return parent::newQuery()->FilterOrders();
        }

        return parent::newQuery();
    }
   public function OrderItem(): HasOne
   {
      return $this->hasOne(Order_items::class, 'order_code', 'order_code');
   }

   /**
    * Get all of the OrderItems for the Orders
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function OrderItems(): HasMany
   {
      return $this->hasMany(Order_items::class, 'order_code', 'order_code');
   }
   /**
    * Get all of the Payments for the Orders
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function Payments(): HasMany
   {
       return $this->hasMany(order_payments::class, 'order_id', 'order_code');
   }
   /**
    * Get the User that owns the Orders
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function User(): BelongsTo
   {
      return $this->belongsTo(User::class, 'user_code', 'user_code');
   }
   /**
    * Get the Customer that owns the Orders
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Customer(): BelongsTo
   {
      return $this->belongsTo(customers::class, 'customerID', 'id');
   }

   public function deliveries()
   {
       return $this->hasMany(Delivery::class, 'order_code','order_code');
   }
}
