<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PickingSheetController extends Controller
{


   public function __invoke()
   {
      $products = session()->get('products');
      view()->share('products', $products);
      $code = 'PS' . ':' . strtoupper(Str::random(5));
      $uuid = Str::uuid();

      $data = $this->calculateProductData($products);
      return view('livewire.picking-sheet.layout', [
         'data' => $data,
         'code' => $code,
         'uuid' => $uuid,
      ]);
   }
   function calculateProductData($inputArray)
   {
      $productCounts = array();
      $productTotals = array();

      // Calculate counts and totals for each product
      if (isset($inputArray)) {
         foreach ($inputArray as $item) {
            foreach ($item->OrderItems as $value) {
               $name = $value['product_name'];
               $price = $value['selling_price'];
               if (!isset($productCounts[$name])) {
                  $productCounts[$name] = 0;
                  $productTotals[$name] = 0;
               }

               $productCounts[$name]++;
               $productTotals[$name] += $price;
            }
         }
      }
      // Combine product data into output array
      $outputArray = array();
      foreach ($productCounts as $name => $count) {
         $total = $count * $productTotals[$name];
         $outputArray[] = array(
            'name' => $name,
            'count' => $count,
            'total_price' => $total
         );
      }

      return $outputArray;
   }
}
