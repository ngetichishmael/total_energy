<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CrystalCustomer;
use App\Helpers\CrystalEditCustomer;
use App\Helpers\Customer;
use App\Helpers\EditCustomer;
use App\Helpers\Helper;
use App\Helpers\MKOCustomer;
use App\Helpers\MKOEditCustomer;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Cart;
use App\Models\customers;
use App\Models\customer\checkin;
use App\Models\Delivery;
use App\Models\Delivery_items;
use App\Models\Orders;
use App\Models\Order_items;
use App\Models\order_payments;
use App\Models\Routes;
use App\Models\Route_customer;
use App\Models\Subregion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @group Customers Api's
 *
 * APIs to manage the Customers
 * */
class customersController extends Controller
{
    /**
     * Customer list
     *
     * @param $businessCode
     * @queryParam page_size int size per page. Default to 20
     **/
    public function index(Request $request, $businessCode)
    {
        $user = $request->user();
    
        $subregions = Subregion::where('region_id', $user->route_code)
            ->pluck('id');
    
        if ($subregions->isEmpty()) {
            return response()->json([
                "user" => $user,
                "success" => true,
                "message" => "Customer List",
                "data" => [],
            ]);
        }
        
        $areas = Area::whereIn('subregion_id', $subregions->toArray())
            ->pluck('id');
        
        if ($areas->isEmpty()) {
            return response()->json([
                "user" => $user,
                "success" => true,
                "message" => "Customer List",
                "data" => [],
            ]);
        }
        
        $customers = customers::with('Wallet')
            ->whereIn('route_code', $areas->toArray())
            ->orderBy('id', 'DESC')
            ->get();
        
        // Construct the default image URL
        $defaultImageUrl = asset('images/no-image.png');
        
        // Modify the image URLs
        foreach ($customers as $customer) {
            $imageFileName = $customer->image;
            $imagePath = public_path('images/' . $imageFileName);
            $imageUrl = file_exists($imagePath) ? asset('images/' . $imageFileName) : $defaultImageUrl;
            
            $customer->image = $imageUrl;
        }
    
        return response()->json([
            "user" => $user,
            "success" => true,
            "message" => "Customer List",
            "data" => $customers,
        ]);
    }
    
    
    
    
    

    /**
     * Customer details
     *
     * @param int $id this is the customer unique code
     **/
    public function details($id)
    {
        $customer = customers::with('Wallet')->find($id);

        return response()->json([
            "success" => true,
            "message" => "Customer List",
            "data" => $customer,
        ]);
    }
    public function add_customer(Request $request)
    {
        $route_code = $request->user()->route_code;
        info("route_code=" . $route_code);

        switch ($route_code) {
            case 2:
                $customerModel = MKOCustomer::class;
                break;
            case 1:
                $customerModel = CrystalCustomer::class;
                break;
            default:
                $customerModel = Customer::class;
                break;
        }
        $respond = $customerModel::addCustomer($request);
        return response()->json([$respond], $respond['status']);
    }

    public function editCustomer(Request $request)
    {
        $route_code = $request->user()->route_code;

        switch ($route_code) {
            case 2:
                $customerModel = MKOEditCustomer::class;
                break;
            case 1:
                $customerModel = CrystalEditCustomer::class;
                break;
            default:
                $customerModel = EditCustomer::class;
                break;
        }

        $respond = $customerModel::EditCustomer($request);
        return response()->json([$respond]);
    }
    public function calculate_distance(Request $request)
    {
        $id = $request->user()->id;
        $customer = customers::where('account', $request->customer)->first();
        $lat1 = $customer->latitude;
        $lon1 = $customer->longitude;
        $lat2 = $request->latitude;
        $lon2 = $request->longitude;
        $unit = "K";

        $distance = round(Helper::distance($lat1, $lon1, $lat2, $lon2, $unit), 2);

        // if($distance < 0.05){

        //create a check in session
        $checkin = new checkin();
        $checkin->code = Helper::generateRandomString(20);
        $checkin->customer_id = $customer->id;
        $checkin->account_number = $request->customer;
        $checkin->checkin_type = $this->checkVisit($id, $customer->id);
        $checkin->user_code = Auth::user()->user_code;
        $checkin->ip = Helper::get_client_ip();
        $checkin->start_time = date('H:i:s');
        $checkin->stop_time = date('H:i:s');
        $checkin->business_code = Auth::user()->business_code;
        $checkin->save();

        //recorord activity
        $activities = '<b>' . Auth::user()->name . '</b> Has <b>Checked-in</b> to <i> ' . $customer->customer_name . '</i> @ ' . date('H:i:s');
        $section = 'Customer';
        $action = 'Checkin';
        $business_code = Auth::user()->business_code;
        $activityID = $checkin->code;

        Helper::activity($activities, $section, $action, $activityID, $business_code);

        return redirect()->route('customer.checkin', $checkin->code);

        // }else{
        //    Session::flash('warning','You are not near the customer shop');
        //    return redirect()->back();
        // }

    }

    public function checkVisit($user_id, $customer_id)
    {

        $today = Carbon::today()->format('Y-m-d');
        $visit = null;
        $checker = Routes::with([
            'RouteSales' => function ($query) use ($user_id) {
                $query->where('userID', $user_id);
            },
        ])
            ->where('start_date', '>', $today)
            ->where('end_date', '<', $today)
            ->pluck('route_code');
        if ($checker !== null) {
            $route_customer = Route_customer::whereIn('routeID', $checker)->where('customer_id', $customer_id)->get();
            if ($route_customer !== null) {
                $visit = "Admin";
            }
        }
        return $visit;
    }
    /**
     * Customer deliveries
     *
     * @param string $customerID this is the customer ID
     * @param string $business_code this is the Business code
     **/
    public function deliveries($customerID, $business_code)
    {
        $delivery = Delivery::where('customer', $customerID)->where('business_code', $business_code)->orderby('id', 'desc')->get();

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Customer Deliveries",
            "data" => $delivery,
        ]);
    }

    /**
     * Customer deliveries
     *
     * @param string $code this is the delivery unique code
     **/
    public function delivery_details($code)
    {
        $delivery = Delivery::where('delivery_code', $code)->first();

        //      $products = Delivery_items::join('product_information','product_information.id','=','delivery_items.productID')
        //                               ->where('delivery_code',$code)
        //                             ->get();

        $products = Delivery_items::join('product_price', 'product_price.productID', '=', 'delivery_items.productID')
            ->select('*', DB::raw('(selling_price * allocated_quantity) as total_amount'))
            ->where('delivery_code', $code)
            ->get();
        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Customer added successfully",
            "delivery" => $delivery,
            "products" => $products,
        ]);
    }

    /**
     * Customer Orders
     *
     * @param string $customerID this is the customer ID
     **/
    public function orders($customerID)
    {
        $orders = Orders::where('customerID', $customerID)->orderby('orders.id', 'desc')->get();

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Customer orders",
            "orders" => $orders,
        ]);
    }

    /**
     * Order details
     *
     * @param string $orderCode this is the order code
     **/
    public function order_details($orderCode)
    {
        $order = Orders::where('order_code', $orderCode)->first();
        $items = Order_items::where('order_code', $orderCode)->get();
        $orders = Cart::where('order_code', $orderCode)->get();
        $payment = order_payments::where('order_id', $orderCode)->get();
        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Customer orders",
            "order_items" => $orders,
            "items" => $items,
            "Data" => $order,
            "Payment" => $payment,
        ]);
    }

    /**
     * New orders
     *
     * @param string $customerID this is the customer ID
     **/
    public function new_order($customerID)
    {
        $orders = Orders::where('customerID', $customerID)
            ->where('order_status', 'Pending Delivery')
            ->orderby('orders.id', 'desc')->get();

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Pending Delivery",
            "Data" => $orders,
        ]);
    }
}
