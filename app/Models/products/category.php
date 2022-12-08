<?php
namespace App\Models\products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class category extends Model
{
   protected $table = 'product_category';
   protected $guarded =[''];

   /**
    * Get all of the ProductInformation for the category
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function ProductInformation(): HasMany
   {
       return $this->hasMany(product_information::class, 'category', 'name');
   }

}
