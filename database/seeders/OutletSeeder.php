<?php

namespace Database\Seeders;

use App\Models\OutletType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public $data = [
      "Qx4FstqLJfHwf3WA" => "Supermarket",
      "Qx4FstqLJfHwf3WA" => "WholeSales",
      "Qx4FstqLJfHwf3WA" => "Kiosk",
      "Qx4FstqLJfHwf3WA" => "Mini Supermarket",
      "Qx4FstqLJfHwf3WA" => "Hardware",
      "Qx4FstqLJfHwf3WA" => "Retail Shop",
   ];
   public function run()
   {
      foreach ($this->data as $key => $value) {
         $random = Str::random(20);
         OutletType::updateOrcreate(
            [

               "outlet_code" => $random,
            ],
            [
               "business_code" => $key,
               "outlet_name" => $value
            ]
         );
      }
   }
}
