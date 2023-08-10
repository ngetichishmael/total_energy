<?php

namespace App\Models\customer;

use App\Models\User;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Area; 
use App\Models\Subregion; 
use App\Models\Region; 
use App\Models\AssignedRegion; 


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
            return $query->whereIn('customer_id', function ($subquery) use ($user) {
                $subquery->select('id')
                         ->from('customers')
                         ->whereIn('route_code', function ($routeSubquery) use ($user) {
                             $routeSubquery->select('id')
                                          ->from('areas')
                                          ->whereIn('subregion_id', function ($subregionSubquery) use ($user) {
                                              $subregionSubquery->select('id')
                                                               ->from('subregions')
                                                               ->whereIn('region_id', function ($regionSubquery) use ($user) {
                                                                   $regionSubquery->select('region_id')
                                                                                 ->from('assigned_regions')
                                                                                 ->where('user_code', $user->user_code);
                                                               });
                                          });
                         });
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
