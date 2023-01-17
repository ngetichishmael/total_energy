<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyRoute;
use Illuminate\Http\Request;

class CompanyRouteController extends Controller
{
    public function getCompanyRoutes(Request $request)
    {
      return response()->json([
         "success" => true,
         "message" => "Company routes",
         "Data"=>CompanyRoute::where('business_code',$request->user()->business_code)->get(),
      ]);
    }
}
