<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\products\product_information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomersProductsController extends Controller
{
   public function getAllProducts()
   {
      $productinfo = product_information::with('ProductPrice')->all();
      return response()->json([
         "success" => true,
         "message" => "Product information",
         "products" => $productinfo
      ]);
   }

   public function sendDefaultImage(Request $request)
   {
      $validator           =  Validator::make($request->all(), [
         "image" =>  "required|image|mimes:png,jpg,svg,ico"
      ]);

      $image_path = $request->file('image')->store('image', 'public');
      product_information::updated([
         'image' => $image_path
      ]);
      return response()->json([
         "success" => true,
         "message" => "Total Counts for Orders and Checkings",
         "checkingCount" => $validator
      ]);
   }
}
