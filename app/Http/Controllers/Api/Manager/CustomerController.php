<?php

namespace App\Http\Controllers\api\manager;

use App\Http\Controllers\Controller;
use App\Models\MKOCustomer;
use App\Models\customers;
use App\Models\Region;
use App\Models\Routes;
use App\Models\Area;
use App\Models\Route_customer;
use App\Models\Subregion;
use App\Models\AssignedRegion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   public function getCustomers()
   {
       // Get the authenticated user
       $user = Auth::user();
   
       // Check the user's account type
       if ($user->account_type === 'Admin') {
           $customers = customers::all();
       } else {
           // Retrieve the user's assigned regions
           $assignedRegions = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id')->toArray();
   
           // Retrieve customers assigned to the regions of the authenticated user
           $customers = customers::whereIn('route_code', function ($query) use ($assignedRegions) {
               $query->select('areas.id')
                   ->from('areas')
                   ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                   ->whereIn('subregions.region_id', $assignedRegions);
           })->get();
       }
   
       // Construct the default image URL
       $defaultImageUrl = asset('images/no-image.png');
   
       // Modify the image URLs
       $customers->transform(function ($customer) use ($defaultImageUrl) {
           $imageFileName = $customer->image;
           $imagePath = public_path('images/' . $imageFileName);
           $imageUrl = file_exists($imagePath) ? asset('images/' . $imageFileName) : $defaultImageUrl;
   
           $customer->image = $imageUrl;
   
           return $customer;
       });
   
       return response()->json([
           "success" => true,
           "message" => "Customer List",
           "status" => 200,
           "data" => $customers,
       ]);
   }
   
   public function showCustomerDetails($customerId)
   {
       // Retrieve the customer based on the provided customer ID
       $customer = customers::find($customerId);
   
       if (!$customer) {
           return response()->json(['message' => 'Customer not found'], 404);
       }
   
       $defaultImageUrl = asset('images/no-image.png');
   
       // Modify the image URL
       $imageFileName = $customer->image;
       $imagePath = public_path('images/' . $imageFileName);
       $imageUrl = file_exists($imagePath) ? asset('images/' . $imageFileName) : $defaultImageUrl;
   
       $customer->image = $imageUrl;
   
       // Count the total orders related to this customer
       $totalOrders = $customer->orders()->where('order_status', '<>', 'DELIVERED')->count();
   
       // Count the delivered orders related to this customer
       $deliveredOrders = $customer->orders()->where('order_status', 'DELIVERED')->count();
   
       // Return the customer details along with the image URL and order counts
       return response()->json([
           'status' => 200,
           'success' => true,
           'message' => 'Customer details retrieved successfully',
           'customer' => $customer,
           'orders' => $totalOrders,
           'deliveries' => $deliveredOrders
       ]);
   }

   
   public function searchExternalCustomer(Request $request)
   {
      $route_code = $request->user()->route_code;
      $search = '%' . $request->search . '%';

      $data = MKOCustomer::whereLike(['customer_name'], $search);

      switch ($route_code) {
         case 2:
            $data->where('source', 'odoo');
            break;
         case 1:
            $data->where('source', 'crystal');
            break;
         default:
            $data->where('source', 'crystal');
            break;
      }

      $data = $data->get();

      return response()->json([
         "success" => true,
         "status" => 200,
         "message" => "Search successful",
         "data" => $data,
      ]);
   }
}