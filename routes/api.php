<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {

   //customers
   Route::get('customers/{businessCode}', 'customersController@index');
   Route::post('customers/add-customer', 'customersController@add_customer');
   Route::get('customers/{code}/details', 'customersController@details');
   Route::get('customers/{customerID}/{businessCode}/deliveries', 'customersController@deliveries');
   Route::get('customers/delivery/{code}/details', 'customersController@delivery_details');
   Route::get('customers/{customerID}/orders', 'customersController@orders');
   
   Route::get('customers/order/{orderCode}/details', 'customersController@order_details');
   Route::get('customers/{customerID}/new-order/', 'customersController@new_order');

   //products
   Route::get('products/{businessCode}', 'productsController@index');

   //product categories
   Route::get('products/categories/{businessCode}', 'productCategoriesController@index');
   Route::get('products/{categoryID}/category', 'productCategoriesController@products_by_category');

   //deliveries
   Route::get('deliveries/{businessCode}/{userCode}', 'deliveryController@index');
   Route::get('delivery/{code}/{businessCode}/details', 'deliveryController@details');

   //customer checking
   Route::post('customer/checkin/session',['uses' => 'checkinController@create_checkin_session']);
   Route::get('customer/{CustomerCode}/checkin',['uses' => 'checkinController@checkin','as' => 'customer.checkin']);
   Route::get('checkin/{checkinCode}/stock',['uses' => 'checkinController@stock','as' => 'checkin.stock']);
   Route::get('checkin/{checkinCode}/out',['uses' => 'checkinController@checkout','as' => 'check.out']);
  
  
  
   // Route::post('checkin/{checkinCode}/add-to-cart',['uses' => 'checkinController@add_to_cart','as' => 'add.to.cart']);
  //Route::post('checkin/{checkinCode}/add-to-cart','checkinController@add_to_cart')->middleware('auth:sanctum');

  // Van Sales 
  Route::post('checkin/vansales/{checkinCode}/add-to-cart','CheckingSaleOrderController@VanSales')->middleware('auth:sanctum');

  //New Sales Order

  Route::post('checkin/newsales/{checkinCode}/add-to-cart','CheckingSaleOrderController@NewSales')->middleware('auth:sanctum');




   Route::get('checkin/{checkinCode}/cart',['uses' => 'checkinController@cart','as' => 'checkin.cart']);
   Route::post('checkin/{checkinCode}/order-save',['uses' => 'checkinController@save_order','as' => 'checkin.order.save']);
   Route::get('checkin/{checkinCode}/cart/{id}/delete',['uses' => 'checkinController@cart_delete','as' => 'checkin.cart.delete']);

   Route::get('checkin/{checkinCode}/orders',['uses' => 'checkinController@orders','as' => 'checkin.orders']);

   Route::post('checkin/{checkinCode}/order/edit/reason',['uses' => 'checkinController@order_edit_reason','as' => 'checkin.order.edit.reason']);
   Route::get('checkin/{checkinCode}/order/{orderID}/edit',['uses' => 'checkinController@order_edit','as' => 'checkin.order.edit']);
   Route::post('checkin/{checkinCode}/order/{itemID}/update',['uses' => 'checkinController@order_update','as' => 'checkin.order.update']);
   Route::get('checkin/{checkinCode}/order/{itemID}/delete/item',['uses' => 'checkinController@order_delete_item','as' => 'checkin.order.delete.item']);
   Route::post('checkin/checkinCode/cancel',['uses' => 'checkinController@order_cancellation','as' => 'checkin.order.cancellation']);

   Route::get('route/schedule/{id}',['uses' => 'routeScheduleController@show','as' => 'route.schedule']);
   
   Route::get('checkin/{checkinCode}/visits',['uses' => 'checkinController@visits','as' => 'checkin.visits']);
   Route::post('checkin/{checkinCode}/visit/add',['uses' => 'checkinController@visit_add','as' => 'checkin.visit.add']);

   //checkin visits *History *
   Route::get('checkin/{checkinCode}/order/{orderID}/details',['uses' => 'checkinController@order_details','as' => 'checkin.order.details']);
   
   Route::get('checkin/{checkinCode}/order/{orderID}/print',['uses' => 'checkinController@order_print','as' => 'checkin.order.print']);

   Route::get('latest/allocation/{user_code}',['uses' => 'checkinController@latest_allocation','as' => 'checkin.latest.allocation']);
   Route::get('allocation/history/{user_code}',['uses' => 'checkinController@allocation_history','as' => 'checkin.allocation.history']);

   /*
   |--------------------------------------------------------------------------
   | Authentication
   |--------------------------------------------------------------------------
   */
   Route::post('login',  'AuthController@userLogin');
   Route::post('signup', 'AuthController@userSignUp');
   // Route::get('user/{phonenumber}/details', 'AuthController@user_details');
   
   // send otp
   Route::post('send/otp/{number}','AuthController@sendOTP');
   Route::post('verify/otp/{number}/{otp}','AuthController@verifyOTP');

   Route::post('/reset-password', 'AuthController@updatePassword');

   Route::get('/countOrders','OrdersCountController@index')->middleware('auth:sanctum');
   Route::get('/countVisits','VisitsCountController@index')->middleware('auth:sanctum');
   Route::get('/SalesMade','SalesMadeController@index')->middleware('auth:sanctum');
   Route::get('/NewLeads','NewLeadsController@index')->middleware('auth:sanctum');
   Route::get('/NewLeads','NewLeadsController@index')->middleware('auth:sanctum');


   //Sales History
   //Start
   Route::get('/SalesHistory/{shopID}','SalesHistoryController@index')->middleware('auth:sanctum');
   Route::get('/SalesHistory/vansale/{shopID}','SalesHistoryController@vansales')->middleware('auth:sanctum');
   Route::get('/SalesHistory/newsale/{shopID}','SalesHistoryController@preorder')->middleware('auth:sanctum');

   //End

   Route::post('/scheduleVisit/{CustomerAccountNumber}','VisitScheduleController@NewVisit')->middleware('auth:sanctum');
   Route::get('/scheduleVisit/checkAll','AddNewRouteController@index')->middleware('auth:sanctum');
   Route::post('/AddNewRoute','AddNewRouteController@store')->middleware('auth:sanctum');
   Route::post('/payment','PaymentController@index')->middleware('auth:sanctum');


   //Stock Lift

   Route::post('/stocklift','StockLiftController@index')->middleware('auth:sanctum');
});
