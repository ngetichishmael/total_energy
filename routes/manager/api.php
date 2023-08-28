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
       Route::get('/manager/{phonenumber}/details', [AuthenticationController::class, 'user_details']);
       Route::post('/manager/logout', [AuthenticationController::class, 'logout']);

       Route::get('/manager/customers/list', [CustomerController::class, 'getCustomers']);

       Route::get('/manager/dashboard/data', [DashboardAppController::class, 'dashboard']);
       Route::post('/manager/dashboard/data/custom', [DashboardAppController::class, 'custom']);

       Route::get('/manager/users', [UsersController::class, 'getUsers']);
       Route::post('/manager/send/notification', [SendNotificationController::class, 'receiveNotification']);
       Route::get('/manager/all/regions', [TerritoryInformationsController::class, 'getAllTerritories']);

       Route::get('/manager/all/orders', [OrdersController::class, 'allOrders']);

       Route::get('/manager/routes/data', [RoutesController::class, 'getRoutes']);

       Route::get('/manager/reports/data', [ReportsController::class, 'reports']);

   });
});
