<?php

namespace App\Models\customer;

use Illuminate\Database\Eloquent\Model;
use Auth;
class customers extends Model
{
   Protected $table = 'customers';

   public static function search($search){
      return empty($search) ? static::query() : static::query()
            ->Where('customer_name','like','%'.$search.'%')
            ->orWhere('email','like','%'.$search.'%')
            ->orWhere('phone_number','like','%'.$search.'%')
            ->where('customers.businessID',Auth::user()->businessID);
   }
}
