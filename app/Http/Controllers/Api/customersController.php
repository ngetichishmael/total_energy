<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\customer\customers;
use App\Models\Delivery;
use App\Models\Delivery_items;
use App\Models\Order_items;
use App\Models\Orders;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
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
      $user=$request->user();
   
      $query = customers::where('business_code',$businessCode);
                           if($request->page_size){
                              $query->paginate($request->page_size);
                           }else{
                              $query->paginate(20);
                           }
      $customers = $query->OrderBy('id','DESC')->get();

      return response()->json([
         "user"=>$user,
         "success" => true,
         "message" => "Customer List",
         "data" => $customers
      ]);
   }

   /**
   * Customer details
   *
   * @param int $id this is the customer unique code
   **/
   public function details($id)
   {
      $customer = customers::find($id);

      return response()->json([
         "success" => true,
         "message" => "Customer List",
         "data" => $customer
      ]);
   }

   /**
   * Add Customer
   *
   * @bodyParam customer_name string required as outlet name
   * @bodyParam contact_person string required
   * @bodyParam phone_number string required
   * @bodyParam email string
   * @bodyParam address string
   * @bodyParam latitude string
   * @bodyParam longitude string
   * @bodyParam business_code string required
   * @bodyParam created_by string required user code
   **/
   public function add_customer(Request $request){
      $validator           =  Validator::make($request->all(), [
         "customer_name"   => "required",
         "email"           => "email",
         "contact_person"  => "required",
         "business_code"   => "required",
         "created_by"      => "required",
         "phone_number"    => "required",
         "latitude"        => "required",
         "longitude"       => "required"
      ]);

      if($validator->fails()) {
         return response()->json(["status" => 401, "message" => "validation_error", "errors" => $validator->errors()]);
      }

 		$customer = new customers;
 		$customer->customer_name = $request->customer_name;
      $customer->contact_person = $request->contact_person;
      $customer->phone_number = $request->phone_number;
      $customer->email = $request->email;
      $customer->address = $request->address;
      $customer->latitude = $request->latitude;
      $customer->longitude = $request->longitude;
		$customer->business_code = $request->business_code;
		$customer->created_by = $request->user_code;
 		$customer->save();

      return response()->json([
         "success" => true,
         "status" => 200,
         "message" => "Customer added successfully",
      ]);
   }


   public function calculate_distance(Request $request){
      $customer = customers::where('account',$request->customer)->first();
      $lat1 = $customer->latitude;
      $lon1 = $customer->longitude;
      $lat2 = $request->latitude;
      $lon2 = $request->longitude;
      $unit = "K";

      $distance = round(Helper::distance($lat1, $lon1, $lat2, $lon2, $unit),2);

      // if($distance < 0.05){

         //create a check in session
         $checkin = new checkin;
         $checkin->code = Helper::generateRandomString(20);
         $checkin->customer_id =  $customer->id;
         $checkin->account_number = $request->customer;
         $checkin->checkin_type = $request->checkin_type;
         $checkin->user_code = Auth::user()->user_code;
         $checkin->ip = Helper::get_client_ip();
         $checkin->start_time = date('H:i:s');
         $checkin->business_code = Auth::user()->business_code;
         $checkin->save();

         //recorord activity
         $activities = '<b>'.Auth::user()->name.'</b> Has <b>Checked-in</b> to <i> '.$customer->customer_name.'</i> @ '.date('H:i:s');
         $section = 'Customer';
         $action = 'Checkin';
         $business_code = Auth::user()->business_code;
         $activityID = $checkin->code;

		   Helper::activity($activities,$section,$action,$activityID,$business_code);

         return redirect()->route('customer.checkin',$checkin->code);

      // }else{
      //    Session::flash('warning','You are not near the customer shop');
      //    return redirect()->back();
      // }

   }

   /**
   * Customer deliveries
   *
   * @param string $customerID this is the customer ID
   * @param string $business_code this is the Business code
   **/
   public function deliveries($customerID,$business_code){
      $delivery = Delivery::where('customer',$customerID)->where('business_code',$business_code)->orderby('id','desc')->get();

      return response()->json([
         "success"  => true,
         "status"   => 200,
         "message"  => "Customer Deliveries",
         "data" => $delivery,
      ]);
   }

   /**
   * Customer deliveries
   *
   * @param string $code this is the delivery unique code
   **/
   public function delivery_details($code){
      $delivery = Delivery::where('delivery_code',$code)->first();

//      $products = Delivery_items::join('product_information','product_information.id','=','delivery_items.productID')
  //                               ->where('delivery_code',$code)
    //                             ->get();

			
	$products = Delivery_items::join('product_price','product_price.productID','=','delivery_items.productID')
                                 ->select('*',DB::raw('(selling_price * allocated_quantity) as total_amount'))
                                 ->where('delivery_code',$code)
                                 ->get();
      return response()->json([
         "success"  => true,
         "status"   => 200,
         "message"  => "Customer added successfully",
         "delivery" => $delivery,
         "products" => $products,
      ]);
   }

   /**
   * Customer Orders
   *
   * @param string $customerID this is the customer ID
   **/
   public function orders($customerID){
      $orders = Orders::where('customerID',$customerID)->orderby('orders.id','desc')->get();

      return response()->json([
         "success"  => true,
         "status"   => 200,
         "message"  => "Customer orders",
         "orders" => $orders,
      ]);
   }

   /**
   * Order details
   *
   * @param string $orderCode this is the order code
   **/
   public function order_details($orderCode){
      $order = Orders::where('order_code',$orderCode)->first();
      $orders=DB::select('SELECT
      `id`,
      `order_code`,
      `productID`,
      `product_name`,
      `quantity`,
      `sub_total`,
      `total_amount`,
      `selling_price`,
      `discount`,
      `taxrate`,
      `taxvalue`,
      `created_at`,
      `updated_at`
  FROM
      `order_items`
  WHERE `order_code`=?', [$orderCode]);
      // $orderItems = Order_items::join('product_information','product_information.id','=','order_items.productID')
      //                         ->where('order_code',$orderCode)
      //                         ->orderby('product_information.id','desc')
      //                         ->get();

      return response()->json([
         "success"  => true,
         "status"   => 200,
         "message"  => "Customer orders",
         "order" => $order,
         "order_items" => $orders,
      ]);
   }

   /**
   * New orders
   *
   * @param string $customerID this is the customer ID
   **/
   public function new_order($customerID){
      $orders = Orders::where('customerID',$customerID)
      ->where('order_status','Pending Delivery')
      ->orderby('orders.id','desc')->get();

      return response()->json([
         "success"  => true,
         "status"   => 200,
         "message"  => "Pending Delivery",
         "orders" => $orders,
      ]);
   }

}
