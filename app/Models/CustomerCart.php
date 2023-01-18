<?php

namespace App\Models;

use App\Models\products\product_information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomerCart extends Model
{
   use HasFactory;
   protected $table = "customer_carts";
   protected $guarded = [""];
   /**
    * Get the ProductInformation associated with the CustomerCart
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function ProductInformation(): HasOne
   {
      return $this->hasOne(product_information::class, 'id', 'product_id');
   }
}
