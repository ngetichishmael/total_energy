<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class activity_log extends Model
{
   protected $table = 'activity_log';
   protected $guarded = [''];
   use Searchable;
   protected $searchable = ['user.name', 'activity', 'action', 'section'];

   public function scopeFilterActivityLog($query)
   {
       // Check if the user is logged in
       if (Auth::check()) {
           $user = Auth::user();
   
           // Check if the user is an Admin
           if ($user->account_type == 'Admin') {
               return $query;
           } else {
               // Filter logs based on the user's route_code
               return $query->whereIn('user_code', function ($subQuery) use ($user) {
                   $subQuery->select('user_code')
                            ->from('users')
                            ->where('route_code', $user->route_code);
               });
           }
       }
       return $query;
   }
   
   public function newQuery()
   {
       // Check if the current route requires web middleware
       if (Route::current() && in_array('web', Route::current()->middleware())) {
           // Apply the filterActivityLog scope
           return parent::newQuery()->filterActivityLog();
       }
       return parent::newQuery();
   }

   public function user()
   {
      return $this->belongsTo(User::class, 'user_code', 'user_code');
   }
}