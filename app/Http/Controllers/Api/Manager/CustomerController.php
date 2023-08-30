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
    
    // Retrieve the user's assigned regions
    $assignedRegions = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id');
    
    // Retrieve customers assigned to the regions of the authenticated user
    $customers = customers::whereIn('route_code', function ($query) use ($assignedRegions) {
        $query->select('areas.id')
            ->from('areas')
            ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
            ->whereIn('subregions.region_id', $assignedRegions);
    })->get();
    
   //  return response()->json($customers);

      // $user = Auth::user(); // Fetch the authenticated user

      // $route_code = $user->route_code;
      // $region = Region::whereId($route_code)->first();
      // $subregion = Subregion::where('region_id', $region->id)->pluck('id');
      // $areas = Area::whereIn('subregion_id', $subregion)->pluck('id');

      // $query = customers::whereIn('route_code', $areas)->get();

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
   
        // Construct the image URL
        $defaultImageUrl = asset('images/no-image.png');
        $imagePath = $customer->image;
        $imageUrl = $defaultImageUrl;
    
        // Check if the image file exists
        if ($imagePath && file_exists(public_path($imagePath))) {
            $imageUrl = asset($imagePath);
        }
        
   
       // Return the customer details along with the image URL
       return response()->json([
           'customer' => [
               'id' => $customer->id,
               'soko_uuid' => $customer->soko_uuid,
               'external_uuid' => $customer->external_uuid,
               'source' => $customer->source,
               'customer_name' => $customer->customer_name,
               'account' => $customer->account,
               'manufacturer_number' => $customer->manufacturer_number,
               'vat_number' => $customer->vat_number,
               'approval' => $customer->approval,
               'delivery_time' => $customer->delivery_time,
               'address' => $customer->address,
               'city' => $customer->city,
               'province' => $customer->province,
               'postal_code' => $customer->postal_code,
               'country' => $customer->country,
               'latitude' => $customer->latitude,
               'longitude' => $customer->longitude,
               'contact_person' => $customer->contact_person,
               'telephone' => $customer->telephone,
               'customer_group' => $customer->customer_group,
               'customer_secondary_group' => $customer->customer_secondary_group,
               'price_group' => $customer->price_group,
               'route' => $customer->route,
               'route_code' => $customer->route_code,
               'region_id' => $customer->region_id,
               'subregion_id' => $customer->subregion_id,
               'zone_id' => $customer->zone_id,
               'unit_id' => $customer->unit_id,
               'branch' => $customer->branch,
               'status' => $customer->status,
               'email' => $customer->email,
               'image' => $imageUrl,
               'phone_number' => $customer->phone_number,
               'business_code' => $customer->business_code,
               'created_by' => $customer->created_by,
               'updated_by' => $customer->updated_by,
               'created_at' => $customer->created_at,
               'updated_at' => $customer->updated_at,
           ]
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