<?php

namespace App\Models\customer;

use App\Models\User;
use App\Models\AssignedRegion;
use App\Traits\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class checkin extends Model
{
   use Searchable;
   protected $table = 'customer_checkin';
   public $guarded = [];

   protected $searchable = [
      'User.name',
      'User.Region.name'
   ];
   /**
    * Get the user that owns the checkin
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function scopeFilterVisits($query)
    {
        $user = Auth::user();

        if (Auth::check() && $user->account_type != 'Admin') {
            $userRegionIds = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id');
            return $query->whereIn('customer_id', function ($subquery) use ($userRegionIds) {
                $subquery->select('id')
                         ->from('customers')
                         ->whereIn('region_id', $userRegionIds);
            });
        }

        return $query;
    }

    public function newQuery()
    {
        if (Route::current() && in_array('web', Route::current()->middleware())) {
            return parent::newQuery()->FilterVisits();
        }

        return parent::newQuery();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'user_code');
    }
   /**
    * Get the Customer that owns the checkin
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Customer(): BelongsTo
   {
      return $this->belongsTo(customers::class, 'customer_id', 'id');
   }

   /**
    * Get the Selfcustomer that owns the checkin
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Self(): BelongsTo
   {
      return $this->belongsTo(customers::class, 'customer_id', 'id')->where('checkin_type', 'self');
   }
   /**
    * Get the Selfcustomer that owns the checkin
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Imprompt(): BelongsTo
   {
      return $this->belongsTo(customers::class, 'customer_id', 'id')->whereNull('checkin_type');
   }
   /**
    * Get the Selfcustomer that owns the checkin
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Admin(): BelongsTo
   {
      return $this->belongsTo(customers::class, 'customer_id', 'id')->where('checkin_type', 'admin');
   }
}
