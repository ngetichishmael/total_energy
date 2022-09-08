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
    // $surveyOnline= Survey::with('questions.type.answers')
    //               ->where('type', $typeOnline)
    //               ->get();
    $surveyOnline= Survey::with(['questions.type.answers'],['questions.answers'])
                  ->where('type', $typeOnline)
                  ->get();
    return response()->json([
      "success" => true,
      "message" => "Survey",
      "Result"    => $surveyOnline
    ]);
  }
}
