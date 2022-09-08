<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\survey\survey as Survey;
use Illuminate\Support\Facades\DB;

class surveyController extends Controller
{

  public function index()
  {
    $typeOnline = "online";
    $surveyOnline= Survey::with('questions.type')
                  ->where('type', $typeOnline)
                  ->get();

    //$surveyOnline = DB::select('SELECT * FROM `survey` where type=?', [$typeOnline]);
    return response()->json([
      "success" => true,
      "message" => "All Available Product Information",
      "Result"    => $surveyOnline
      //"Data" =>  $this->data()
    ]);
  }
}
