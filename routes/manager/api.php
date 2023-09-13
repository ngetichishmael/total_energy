<?php

use App\Http\Controllers\Api\Manager\AuthenticationController;
use App\Http\Controllers\Api\Manager\CustomerController;
use App\Http\Controllers\Api\Manager\DashboardAppController;
use App\Http\Controllers\Api\Manager\OrdersController;
use App\Http\Controllers\Api\Manager\SendNotificationController;
use App\Http\Controllers\Api\Manager\TerritoryInformationsController;
use App\Http\Controllers\Api\Manager\UsersController;
use App\Http\Controllers\Api\Manager\RoutesController;
use App\Http\Controllers\Api\Manager\ReportsController;
use App\Http\Controllers\Api\Manager\VisitsController;
use App\Http\Controllers\Api\Manager\TargetController;
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

   /*
   |--------------------------------------------------------------------------
   | Authentication
   |--------------------------------------------------------------------------
   */
   Route::post('/manager/login', [AuthenticationController::class, 'login']);
   Route::post('/manager/reset/otp/{number}', [AuthenticationController::class, 'sendOTP']);
   Route::post('/manger/verify/otp/{number}/{otp}', [AuthenticationController::class, 'verifyOTP']);
   Route::post('/manager/reset/password/update', [AuthenticationController::class, 'updatePassword']);
   Route::post('signup', 'AuthController@userSignUp');

   // Authenticated routes
   Route::middleware(['auth:sanctum'])->group(function () {
       Route::get('/manager/{user_code}/details', [AuthenticationController::class, 'user_details']);
       Route::post('/manager/logout', [AuthenticationController::class, 'logout']);

       Route::get('/manager/customers/list', [CustomerController::class, 'getCustomers']);
       Route::get('/manager/customer/{id}/details', [CustomerController::class, 'showCustomerDetails']);
       Route::post('/manager/customer/{id}/orders', [OrdersController::class, 'showCustomerOrders']);
       Route::post('/manager/customer/{id}/deliveries', [OrdersController::class, 'showCustomerDeliveries']);



       Route::get('/manager/dashboard/data', [DashboardAppController::class, 'dashboard']);
       Route::post('/manager/dashboard/data/custom', [DashboardAppController::class, 'custom']);

       Route::get('/manager/users', [UsersController::class, 'getUsers']);
       Route::post('/manager/user/{user_code}/details', [UsersController::class, 'getUserDetails']);
       Route::post('/manager/deactivate/user/{user_code}', [UsersController::class, 'suspendUser']);
       Route::post('/manager/activate/user/{user_code}', [UsersController::class, 'activateUser']);
       Route::get('/manager/users/account_types', [UsersController::class, 'accountTypes']);

       Route::post('/manager/send/notification', [SendNotificationController::class, 'receiveNotification']);
       Route::get('/manager/all/regions', [TerritoryInformationsController::class, 'getAllTerritories']);

       Route::get('/manager/all/orders', [OrdersController::class, 'allOrders']);
       Route::get('/manager/orders/vansales', [OrdersController::class, 'vansales']);
       Route::get('/manager/orders/completed', [OrdersController::class, 'completedOrders']);
       Route::get('/manager/orders/pending', [OrdersController::class, 'pendingOrders']);
       Route::get('/manager/orders/pending/deliveries', [OrdersController::class, 'waitingAcceptanceOrders']);

       Route::get('/manager/order/{order_code}/details', [OrdersController::class, 'showOrderDetails']);
       Route::post('/manager/orders/allocation', [OrdersController::class, 'allocatingOrders']);

       Route::get('/manager/customers/checkins', [VisitsController::class, 'getCustomerCheckins']);

       Route::get('/manager/routes/data', [RoutesController::class, 'getRoutes']);

       Route::get('/manager/reports/data', [ReportsController::class, 'reports']);

       Route::get('/manager/vansales/today', [ReportsController::class, 'vanSalesToday']);
       Route::get('/manager/vansales/yesterday', [ReportsController::class, 'vanSalesYesterday']);
       Route::get('/manager/vansales/current-week', [ReportsController::class, 'vanSalesThisWeek']);
       Route::get('/manager/vansales/last-week', [ReportsController::class, 'vanSalesLastWeek']);
       Route::get('/manager/vansales/current-month', [ReportsController::class, 'vanSalesThisMonth']);
       Route::get('/manager/vansales/last-month', [ReportsController::class, 'vanSalesLastMonth']);
 
       Route::get('/manager/preorder/today', [ReportsController::class, 'preOrderToday']);
       Route::get('/manager/preorder/yesterday', [ReportsController::class, 'preOrderYesterday']);
       Route::get('/manager/preorder/current-week', [ReportsController::class, 'preOrderThisWeek']);
       Route::get('/manager/preorder/last-week', [ReportsController::class, 'preOrderLastWeek']);
       Route::get('/manager/preorder/current-month', [ReportsController::class, 'preOrderThisMonth']);
       Route::get('/manager/preorder/last-month', [ReportsController::class, 'preOrderLastMonth']);

       Route::get('/manager/visits/today', [ReportsController::class, 'visitsToday']);
       Route::get('/manager/visits/yesterday', [ReportsController::class, 'visitsToday']);
       Route::get('/manager/visits/current-week', [ReportsController::class, 'visitsToday']);
       Route::get('/manager/visits/last-week', [ReportsController::class, 'visitsWeek']);
       Route::get('/manager/visits/current-month', [ReportsController::class, 'visitsMonth']);
       Route::get('/manager/visits/last-month', [ReportsController::class, 'visitsMonth']);

 
       Route::get('/manager/active-users/today', [\App\Http\Controllers\Api\Manager\ReportsController::class, 'activeUsersToday']);
       Route::get('/manager/active-users/last-week', [\App\Http\Controllers\Api\Manager\ReportsController::class, 'activeUsersWeek']);
       Route::get('/manager/active-users/last-month', [\App\Http\Controllers\Api\Manager\ReportsController::class, 'activeUsersMonth']);
 
       Route::get('/manager/orders/completed', [ReportsController::class, 'orderFulfillment']);

       Route::post('/manager/assign/lead/target', [TargetController::class, 'assignLeadTarget']);
       Route::post('/manager/assign/sale/target', [TargetController::class, 'assignSaleTarget']);
       Route::post('/manager/assign/visit/target', [TargetController::class, 'assignVisitTarget']);
       Route::post('/manager/assign/order/target', [TargetController::class, 'assignOrderTarget']);

       Route::get('/manager/all/regions', [TerritoryInformationsController::class, 'getAllTerritories']);


   });
});
