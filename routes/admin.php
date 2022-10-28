<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
   Route::resource('target/sales', app\Target\SalesController::class)->names([
      'index' => 'sales.target',
      'show' => 'sales.target.show',
      'edit' => 'sales.target.edit',
      'update' => 'sales.target.update',
      'destroy' => 'sales.target.destroy',
      'create' => 'sales.target.create',
      'store' => 'sales.target.store',
  ]);
   Route::resource('target/visit', app\Target\VisitsController::class)->names([
      'index' => 'visit.target',
      'show' => 'visit.target.show',
      'edit' => 'visit.target.edit',
      'update' => 'visit.target.update',
      'destroy' => 'visit.target.destroy',
      'create' => 'visit.target.create',
      'store' => 'visit.target.store',
  ]);
   Route::resource('target/leads', app\Target\LeadsController::class)->names([
      'index' => 'leads.target',
      'show' => 'leads.target.show',
      'edit' => 'leads.target.edit',
      'update' => 'leads.target.update',
      'destroy' => 'leads.target.destroy',
      'create' => 'leads.target.create',
      'store' => 'leads.target.store',
  ]);
   Route::resource('order', app\Target\OrdersController::class)->names([
      'index' => 'order.target',
      'show' => 'order.target.show',
      'edit' => 'order.target.edit',
      'update' => 'order.target.update',
      'destroy' => 'order.target.destroy',
      'create' => 'order.target.create',
      'store' => 'order.target.store',
  ]);
});

