<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\survey\questions;
use App\Models\survey\survey as Survey;

class surveyController extends Controller
{

  public function getAllSurvey()
  {
    $survey= Survey::all();
    
    return response()->json([
      "success" => true,
      "message" => "Survey",
      "Survey" => $survey
    ]);
  }
  public function getAllQuestions($surveyCode){
    $questions= questions::with('type','options')
    ->where('survey_code', $surveyCode)
    ->get();
    return response()->json([
      "success" => true,
      "message" => "All questions",
      "Survey" => $questions
    ]);
  }
}
