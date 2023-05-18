<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

class customers extends Model
{
   use searchable;
   protected $searchable = [
      'Area.name',
      'customer_name',
      'phone_number',
      'address',
      'Area.Subregion.name',
      'Area.Subregion.Region.name',
   ];
   protected $table = 'customers';
   protected $guarded  = [''];

   public function scopeFilterCustomers($query)
   {
      if (Auth::check()) {
         $user = Auth::user();
         if ($user->account_type === 'Admin') {
            return $query;
         }
         return $query->where('route_code', $user->route_code);
      }
   }

   public function newQuery()
   {
      if (Route::current() && Route::current()->middleware() === ['web']) {
         return parent::newQuery()->filterCustomers();
      }

      return parent::newQuery();
   }

   /**
    * Get the Region that owns the customers
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
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
      return $this->hasOne(User::class, 'user_code', 'created_by');
   }
   /**
    * Get the Area that owns the customers
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Area(): BelongsTo
   {
      return $this->belongsTo(Area::class, 'route_code', 'id');
   }
}
