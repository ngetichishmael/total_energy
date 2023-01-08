<?php

use App\Http\Controllers\Api\Manager\AuthenticationController;
use App\Http\Controllers\Api\Manager\CustomerController;
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
   Route::post('/manager/login',  [AuthenticationController::class, 'login']);
   Route::post('signup', 'AuthController@userSignUp');
   Route::middleware(['auth:sanctum'])->group(function () {
      Route::get('/manager/customers', [CustomerController::class, 'getCustomers']);
      Route::get('/manager/users', [UsersController::class, 'getUsers']);
   });
});