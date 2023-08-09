<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class activity_log extends Model
{
   protected $table = 'activity_log';
   protected $guarded = [''];

   use Searchable;
   protected $searchable = ['user.name', 'activity', 'action', 'section'];
   public function user()
   {
      return $this->belongsTo(User::class, 'user_code', 'user_code');
   }
}