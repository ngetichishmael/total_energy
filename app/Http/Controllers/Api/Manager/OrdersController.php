<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;

use App\Helpers\SMS;
use App\Models\activity_log;
use App\Models\Cart;
use App\Models\customers;
use App\Models\Delivery;
use App\Models\Delivery_items;
use App\Models\Orders;
use App\Models\Orders as Order;
use App\Models\Order_items;
use App\Models\order_payments;
use App\Models\products\product_information;
use App\Models\products\product_inventory;
use App\Models\products\product_price;
use App\Models\suppliers\suppliers;
use App\Models\User;
use App\Models\warehousing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use App\Models\inventory\items;
use App\Models\Subregion;
use App\Models\AssignedRegion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{

   public function allOrders(Request $request)
   {
       // Get the authenticated user
       $user = Auth::user();
       
       // Retrieve the user's assigned regions
       $assignedRegions = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id');
       
       // Retrieve customer orders assigned to the regions of the authenticated user
       $orders = Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
           $query->select('customers.id')
               ->from('customers')
               ->join('areas', 'customers.route_code', '=', 'areas.id')
               ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
               ->whereIn('subregions.region_id', $assignedRegions);
       })
       ->with('customer', 'user','orderitems') // Eager load relationships
       ->get();
       
       return response()->json([
           'status' => 200,
           'success' => true,
           'message' => 'Filtered Orders based on the Managers Assigned Routes ,with the Order items, the Sales associate, and the customer',
           'Data' => $orders
       ]);
   }

    public function vansales(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Retrieve the user's assigned regions
        $assignedRegions = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id');
        
        // Retrieve customer orders assigned to the regions of the authenticated user with order_type "Van Sales" and order by created_at in descending order
        $orders = Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
            $query->select('customers.id')
                ->from('customers')
                ->join('areas', 'customers.route_code', '=', 'areas.id')
                ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                ->whereIn('subregions.region_id', $assignedRegions);
        })
        ->where('order_type', 'Van sales') // Filter by order_type
        ->with('customer', 'user', 'orderitems') // Eager load relationships
        ->orderBy('created_at', 'desc') // Order by created_at in descending order
        ->get();
        
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Filtered Van Sales Orders based on the Manager\'s Assigned Routes, with the Order items, the Sales associate, and the customer',
            'Data' => $orders
        ]);
    }

    public function waitingAcceptanceOrders(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Retrieve the user's assigned regions
        $assignedRegions = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id');
        
        // Retrieve customer orders assigned to the regions of the authenticated user with order_status "Waiting Acceptance"
        $orders = Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
            $query->select('customers.id')
                ->from('customers')
                ->join('areas', 'customers.route_code', '=', 'areas.id')
                ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                ->whereIn('subregions.region_id', $assignedRegions);
        })
        ->where('order_status', 'Waiting acceptance') // Filter by order_status
        ->where('order_type', 'Pre Order') // Filter by order_type
        ->with('customer', 'user', 'orderitems') // Eager load relationships
        ->orderBy('created_at', 'desc') // Order by created_at in descending order
        ->get();
        
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Filtered pending deliveries Orders based on the Manager\'s Assigned Routes, with the Order items, the Sales associate, and the customer',
            'Data' => $orders
        ]);
    }


    public function completedOrders(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Retrieve the user's assigned regions
        $assignedRegions = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id');
        
        // Retrieve completed customer orders assigned to the regions of the authenticated user with order_type "Pre Order" and order_status "delivered" or "partially delivered"
        $orders = Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
            $query->select('customers.id')
                ->from('customers')
                ->join('areas', 'customers.route_code', '=', 'areas.id')
                ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                ->whereIn('subregions.region_id', $assignedRegions);
        })
        ->where('order_type', 'Pre Order')
        ->orderBy('created_at', 'desc') 
        ->where(function ($query) {
            $query->where('order_status', 'delivered')
                ->orWhere('order_status', 'Partial delivery'); // Filter by order_status (delivered or partially delivered)
        })
        ->with('customer', 'user', 'orderitems') // Eager load relationships
        ->get();
        
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Filtered Completed Pre Order Orders based on the Manager\'s Assigned Routes, with the Order items, the Sales associate, and the customer',
            'Data' => $orders
        ]);
    }
    

    public function pendingOrders(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Retrieve the user's assigned regions
        $assignedRegions = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id');
        
        // Retrieve pending customer orders assigned to the regions of the authenticated user with order_status "Pending Delivery"
        $orders = Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
            $query->select('customers.id')
                ->from('customers')
                ->join('areas', 'customers.route_code', '=', 'areas.id')
                ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                ->whereIn('subregions.region_id', $assignedRegions);
        })
        ->where('order_status', 'Pending Delivery') // Filter by order_status
        ->where('order_type', 'Pre Order') // Filter by order_type
        ->with('customer', 'user', 'orderitems') // Eager load relationships
        ->orderBy('created_at', 'desc') // Order by created_at in descending order
        ->get();
        
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Pending Orders based on the Manager\'s Assigned Routes, with the Order items, the Sales associate, and the customer',
            'Data' => $orders
        ]);
    }



   public function showCustomerOrders($customerId)
   {
       // Retrieve the customer based on the provided customer ID
       $customer = customers::find($customerId);
   
       if (!$customer) {
           return response()->json(['message' => 'Customer not found'], 404);
       }
   
       // Retrieve the customer's orders with their associated order items
       $ordersWithItems = $customer->orders()
           ->with('orderItems')
           ->get();
   
       // Transform the data into the desired format
       $formattedData = [
           'status' => 200,
           'success' => true,
           'message' => 'Customer and there associated orders retrieved successfully',
           'data' => [
               'customer' => $customer->toArray(),
               'orders' => []
           ]
       ];
   
       foreach ($ordersWithItems as $order) {
           $formattedOrder = $order->toArray();
           $formattedOrder['order_items'] = $order->orderItems->toArray();
           $formattedData['data']['orders'][] = $formattedOrder;
       }
   
       // Return the customer and their associated orders with items
       return response()->json($formattedData);
   }
   
   public function showCustomerDeliveries(Request $request, $id)
   {
       // Assuming you have a Customer model with a relationship to orders, you can retrieve the customer's orders.
       $customer = customers::find($id);
       $custom = customers::find($id);

       if (!$customer) {
           return response()->json(['message' => 'Customer not found'], 404);
       }

       // Fetch the orders with "Delivered" status for the customer.
       $deliveries = $customer->orders()->where('order_status', 'Delivered')->get();

       return response()->json([
        'status' => 200,
        'success' => true,
        'message' => 'Customer and there associated Deliveries retrieved successfully',
        'customer' => $custom,
        'orders' => $deliveries]);
   } 
   

   

    public function filter($region_id): array
    {

        $array = [];
        $customers = customers::where('region_id', $region_id)->pluck('id');
        if ($customers->isEmpty()) {
            return $array;
        }
        $orders = Orders::whereIn('customerID', $customers)->pluck('id');
        if ($orders->isEmpty()) {
            return $array;
        }
        return $orders->toArray();
    }
    public function filterOrders($region_id): array
    {

        $array = [];
        $customers = customers::where('region_id', $region_id)->pluck('id');
        if ($customers->isEmpty()) {
            return $array;
        }
        return $customers->toArray();
    }

    public function showOrderDetails($order_code)
    {
        // Retrieve the order based on the provided order code
        $order = Orders::where('order_code', $order_code)
            ->with('customer', 'user', 'orderitems')
            ->first();
    
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
    
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Order details retrieved successfully',
            'data' => $order
        ]);
    }
    

    public function allOrdersUsingAPIResource(Request $request)
    {
        return response()->json([
            'status' => 200,
            'success' => true,
            'Data' => UserResource::collection(
                User::withCount(['Checkings'])->with('Orders.OrderItem')
                    ->where('route_code', $request->user()->route_code)
                    ->whereIn('account_type', ['TSR', 'TD', 'RSM'])
                    ->get()
            ),
        ]);
    }

    public function allOrderForCustomers(Request $request)
    {
        return response()->json([
            'status' => 200,
            'success' => true,
            "message" => "Order information for customers",
            'Data' => CustomerResource::collection(
                customers::withCount(['Checkings'])
                    ->where('region_id', $request->user()->route_code)
                    ->with('Orders.OrderItem')
                    ->get()
            ),
        ]);
    }

    public function allocatingOrders(Request $request)
    {
        // Validate the request payload
        $this->validate($request, [
            'order_code' => 'required|string', // Assuming 'order_code' is a string
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer',
            'products.*.allocated_quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
            'user_code' => 'required|string',
        ]);
    
        // Check if the order with the provided 'order_code' exists
        $order = Order::where('order_code', $request->order_code)->first();
    
        if (!$order) {
            return response()->json([
                "success" => false,
                'message' => 'Order not found'], 404);
        }
    
        // Initialize variables for tracking total sum and quantity
        $totalSum = 0;
        $quantity = 0;

         // Check if a delivery with the same 'order_code' already exists
    $delivery = Delivery::where('order_code', $request->order_code)->first();

    // If a delivery already exists, update it; otherwise, create a new one
    if ($delivery) {
        // Update the existing delivery
        $delivery->update([
            "allocated" => $request->user_code,
            "delivery_note" => $request->note,
            "delivery_status" => "Waiting acceptance",
            "Type" => "Warehouse",
            "created_by" => Auth::user()->user_code,
        ]);
    } else {
        // Create a new delivery record
        $delivery = Delivery::create([
            "business_code" => Str::random(20),
            "order_code" => $request->order_code,
            "delivery_code" => Str::random(20),
            "allocated" => $request->user_code,
            "delivery_note" => $request->note,
            "delivery_status" => "Waiting acceptance",
            "Type" => "Warehouse",
            "created_by" => Auth::user()->user_code,
        ]);
    }
    
        // Create a new delivery record
        // $delivery = Delivery::updateOrCreate(
        //     [
        //         "business_code" => Str::random(20),
        //         "order_code" => $request->order_code,
        //     ],
        //     [
        //         "delivery_code" => Str::random(20),
        //         "allocated" => $request->user_code,
        //         "delivery_note" => $request->note,
        //         "delivery_status" => "Waiting acceptance",
        //         "Type" => "Warehouse",
        //         "created_by" => Auth::user()->user_code,
        //     ]
        // );
    
        foreach ($request->products as $productData) {
            $productId = $productData['product_id'];
            $allocatedQuantity = $productData['allocated_quantity'];
    
            // Check product inventory
            // $check = product_information::where('id', $productId)->first();
    
            // if (!$check || $check->current_stock > $allocatedQuantity) {
            //     return response()->json([
            //         "success" => false,
            //         'message' => "Insufficient stock for product ID $productId"], 400);
            // }
            // Check product inventory
           // Check product inventory and get product name
            $check = product_inventory::where('productID', $productId)->first();

            if (!$check || $allocatedQuantity > $check->current_stock) {
                // Fetch the product name from the product_information table
                $productInfo = product_information::where('id', $productId)->first();
                $productName = $productInfo ? $productInfo->product_name : "Unknown Product";

                return response()->json([
                    "success" => false,
                    'message' => "Insufficient stock for product: $productName",
                ], 400);
            }


    
            // Retrieve product pricing
            $pricing = product_price::where('productID', $productId)->first();
    
            // Calculate subtotal for the allocated quantity
            $subTotal = $pricing->selling_price * $allocatedQuantity;
            $totalSum += $subTotal;
    
            // Create a delivery item record
            Delivery_items::updateOrCreate(
                [
                    "business_code" => Auth::user()->business_code,
                    "delivery_code" => $delivery->delivery_code,
                    "productID" => $productId,
                ],
                [
                    "selling_price" => $pricing->selling_price,
                    "sub_total" => $subTotal,
                    "total_amount" => $subTotal,
                    "product_name" => $pricing->product_name,
                    "allocated_quantity" => $allocatedQuantity,
                    "delivery_item_code" => Str::random(20),
                    "requested_quantity" => $allocatedQuantity, // Change this if needed
                    "created_by" => Auth::user()->user_code,
                ]
            );
    
            // Update the order item with the allocated quantity and subtotal
            Order_items::where('productID', $productId)
                ->where('order_code', $request->order_code)
                ->update([
                    // "requested_quantity" => $allocatedQuantity, // Change this if needed
                    "allocated_quantity" => $allocatedQuantity,
                    "allocated_subtotal" => $subTotal,
                    "allocated_totalamount" => $subTotal,
                ]);
    
            $quantity += $allocatedQuantity;
        }
    
        // Update the order with the new order status, total price, and quantity
        $order->update([
            "order_status" => "Waiting acceptance",
            "price_total" => $totalSum,
            "balance" => $totalSum,
            "initial_total_price" => $order->price_total,
            "updated_qty" => $quantity,
        ]);
    
        // Send a notification to the user
        $user = User::where('user_code', $request->user_code)->first();
    
        if ($user) {
            $phone_number = $user->phone_number;
            $message = "An order (Reference Number: $request->order_code) has been allocated to you and awaits your acceptance. Please check your account for details.";
            info($message);
            // Implement your SMS sending logic here
        } else {
            return response()->json([
                "success" => false,
                'message' => 'User not found'], 404);
        }
    
        // Log the activity
        $random = Str::random(20);
        $activityLog = new activity_log();
        $activityLog->source = 'Web App';
        $activityLog->activity = 'Allocate an order to a User';
        $activityLog->user_code = Auth::user()->user_code;
        $activityLog->section = 'Order Allocation';
        $activityLog->action = "Order allocated to user {$user->name} Role {$request->account_type}";
        $activityLog->userID = Auth::user()->id;
        $activityLog->activityID = $random;
        $activityLog->ip_address = "";
        $activityLog->save();
    
        return response()->json([
            "success" => true,
            'message' => 'Order successfully allocated'], 200);
    }
    

    public function allocateOrders(Request $request)
    {
        $random = Str::random(20);
//      info("Manager allocate orders");
        $json = $request->products;
        $data = json_decode($json, true);
        $validator = Validator::make($request->all(), [
            "customerID" => "required",
            "user_code" => "required",
            "order_code" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => 401,
                    "message" => "validation_error",
                    "errors" => $validator->errors(),
                ],
                403
            );
        }
        $customerID = $request->customerID;
        $sales_person = $request->user_code;
        $order_code = $request->order_code;
        Orders::where('order_code', $order_code)->update([
            'user_code' => $sales_person,
        ]);
        $random = Str::random(20);
        $activityLog = new activity_log();
        $activityLog->activity = 'Manager order allocation';
        $activityLog->user_code = auth()->user()->user_code;
        $activityLog->section = 'Allocate orders';
        $activityLog->action = 'Manager ' . auth()->user()->name . ' allocated order ' . $order_code . ' to ' . $sales_person . ' of customer ' . $customerID;
        $activityLog->userID = auth()->user()->id;
        $activityLog->activityID = $random;
        $activityLog->ip_address = "";
        $activityLog->save();
        return response()->json([
            "success" => true,
            "message" => "Orders allocated to the user successfully",
            "Result" => "Successful",
        ], 200);

    }
    public function allocationItems(Request $request)
    {
        $data = items::with(["Inventory.User", "Information"])->whereNotIn('inventory_allocated_items.is_approved', ['Yes', 'No'])->get();
        $arraydata = array();
        foreach ($data as $value) {
            $arrayFiltered = array();
            $user = $value['inventory'];
            if ($user !== null) {
                $arrayFiltered["OrderedUser"] = $value["inventory"]["user"] == null ? $this->noValue() : $this->returnFilterUser($value["inventory"]["user"]);
                $itemDetails = $value["information"] == null ? $this->noInformation() : $this->returnFilterInformation($value["information"]);
                $itemDetails["allocation_code"] = $value->allocation_code;
                $itemDetails["productID"] = $value->product_code;
                $itemDetails["current_qty"] = $value->current_qty;
                $itemDetails["allocated_qty"] = $value->allocated_qty;
                $arrayFiltered["ItemDetails"] = array_merge($itemDetails, $arrayFiltered["ItemDetails"] ?? []);

                array_push($arraydata, $arrayFiltered);

            }
        }
        return response()->json([
            'status' => 200,
            'success' => true,
            "message" => "Preordered Information",
            'Array' => $arraydata,
        ]);
    }

    public function orderApproval(Request $request)
    {
        info("Manager approve allocated products");
        $json = $request->products;
        $data = json_decode($json, true);
        $validator = Validator::make($request->all(), [
            "productID" => "required",
            "allocation_code" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => 403,
                    "message" => "validation_error",
                    "errors" => $validator->errors(),
                ],
                403
            );
        }
        $productID = $request->productID;
        $allocation_code = $request->allocation_code;
        if (items::where('allocation_code', $allocation_code)
            ->where('product_code', $productID)
            ->exists()) {
            items::where('allocation_code', $allocation_code)
                ->where('product_code', $productID)
                ->update([
                    'approval_time' => Carbon::now(),
                    'approved_by' => Auth()->user()->user_code,
                    'is_approved' => 'yes',
                ]);
            // return success response
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Item approved successfully.',
            ], 200);
        } else {
            // return error response
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Item not found.',
            ], 404);
        }
    }
    public function orderDisapproval(Request $request)
    {
        info("Manager approve allocated products");
        $json = $request->products;
        $data = json_decode($json, true);
        $validator = Validator::make($request->all(), [
            "productID" => "required",
            "allocation_code" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => 403,
                    "message" => "validation_error",
                    "errors" => $validator->errors(),
                ],
                403
            );
        }
        $productID = $request->productID;
        $allocation_code = $request->allocation_code;
        if (items::where('allocation_code', $allocation_code)
            ->where('product_code', $productID)
            ->exists()) {
            items::where('allocation_code', $allocation_code)
                ->where('product_code', $productID)
                ->update([
                    'approval_time' => Carbon::now(),
                    'disapproved_by' => Auth()->user()->user_code,
                    'is_approved' => 'no',
                ]);
            // return success response
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Item approved successfully.',
            ], 200);
        } else {
            // return error response
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Item not found.',
            ], 404);
        }
    }
    public function noValue()
    {
        $arrayData = array();
        $arrayData["id"] = "no value";
        $arrayData["name"] = "no value";
        $arrayData["user_code"] = "no value";
        $arrayData["email"] = "no value";
        return $arrayData;
    }
    public function returnFilterUser($data)
    {
        $arrayData = array();
        if ($data !== null) {
            $arrayData["id"] = $data["id"];
            $arrayData["name"] = $data["name"];
            $arrayData["user_code"] = $data["user_code"];
            $arrayData["email"] = $data["email"];
        }
        return $arrayData;
    }
    public function noInformation()
    {
        $arrayData = array();
        $arrayData["id"] = "no value";
        $arrayData["item_name"] = "no value";
        $arrayData["qty_stocked"] = "no value";
        $arrayData["brand"] = "no value";
        $arrayData["total_amount"] = "no value";
        $arrayData["date"] = "no value";
        return $arrayData;
    }
    public function returnFilterInformation($data)
    {
        $arrayData = array();
        if ($data !== null) {
            $arrayData["id"] = $data["id"];
            $arrayData["item_name"] = $data["product_name"];
            $arrayData["qty_stocked"] = product_inventory::whereId($data["id"])->pluck("current_stock")->implode('');
            $arrayData["brand"] = $data["brand"];
            $arrayData["total_amount"] = product_price::whereId($data["id"])->pluck("buying_price")->implode('');
            $arrayData["date"] = $data["updated_at"];
        }
        return $arrayData;
    }
    public function transaction(Request $request)
    {
        if ($request->user()->account_type === 'RSM') {
            return response()->json([
                'status' => 200,
                'success' => true,
                "message" => "Order information for customers",
                'Data' => OrderResource::collection(
                    Orders::with(['Customer'])->get(),
                ),
                'custom' => $this->customTransaction($request)->getData(),
            ]);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            "message" => "Order information for customers",
            'Data' => OrderResource::collection(
                Orders::with(['Customer'])->get(),
            ),
            'custom' => $this->customTransaction($request)->getData(),
        ]);
    }
    public function customTransaction(Request $request)
    {
        return response()->json([
            'Custom' => OrderResource::collection(
                Orders::with(['Customer'])->period($request->start_date, $request->end_date)->get(),
            ),
        ]);
    }
}