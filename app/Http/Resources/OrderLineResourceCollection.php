<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderLineResourceCollection extends ResourceCollection
{
   /**
    * Transform the resource collection into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
    */
   public function toArray($request)
   {
      return [
         'id' => $this->id,
         'product' => $this->product_name,
         'quantity' => $this->quantity,
         'price_unit' => $this->selling_price,
         'discount' => $this->discount,
         'tax' => $this->taxrate,
      ];
   }
}
