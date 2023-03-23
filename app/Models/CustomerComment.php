<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerComment extends Model
{
   use HasFactory, Searchable;
   protected $guarded = [];

   protected $searchable = [
      'comment',
      'date',
      'User.name',
      'Customer.customer_name',
   ];
   /**
    * Get the user that owns the CustomerComment
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function User(): BelongsTo
   {
      return $this->belongsTo(User::class);
   }
   /**
    * Get the Customer that owns the CustomerComment
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Customer(): BelongsTo
   {
      return $this->belongsTo(customers::class, 'customers_id');
   }
}
