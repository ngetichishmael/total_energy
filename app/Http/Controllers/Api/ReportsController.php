<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function getReports(Request $request)
    {
      $user_code = $request->user()->user_code;
    }
}
