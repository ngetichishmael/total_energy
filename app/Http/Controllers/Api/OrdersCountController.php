<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders as ModelsOrders;
use Illuminate\Http\Request;
class OrdersCountController extends Controller
{
    public function index(){
        
        return ModelsOrders::all();
    }
}
 