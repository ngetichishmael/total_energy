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
    $surveyOnline=DB::select('SELECT `id`,
                              `code`,
                              `title`,
                              `description`,
                              `status`,
                              `start_date`,
                              `end_date`,
                              `type`,
                              `visibility` FROM `survey` where type=?', [$typeOnline]);
    return response()->json([
      "success" => true,
      "message" => "Survey",
      "SurveyDescription" => $surveyOnline,
      "Survey"=> $this->data()
    ]);
  }
    public function data()
  {
    $arrayQuestion =["question(s)"];
    $typeOnline = "online";
    $querySurvey = DB::select('SELECT `code` FROM `survey` where type=?', [$typeOnline]);
    foreach ($querySurvey as $value) {
      $arrayQuestionData = ["option(s)"];
      $query = DB::select('SELECT
        `survey_questions`.`id`,
        `survey_questions`.`survey_code`,
        `survey_question_types`.`name` AS Type,
        `survey_questions`.`question`
          FROM
              `survey_questions`
          INNER JOIN `survey_question_types` ON `survey_questions`.`type` = `survey_question_types`.`id`
          WHERE
              `survey_questions`. `survey_code` = ?
              ', [$value->code]);
      if (!(empty($query))) {
        foreach ($query as $queryID) {
          array_push($arrayQuestionData, $this->arrayQuestions($queryID->id));
        }
        array_push($arrayQuestion, $query, $arrayQuestionData);
      }
    }
    info($arrayQuestion);
    return $arrayQuestion;
  }

  public function arrayQuestions($id)
  {
    $questions = DB::select('SELECT
        `id`,
        `survey_code`,
        `questionID`,
        `option_a`,
        `option_b`,
        `option_c`,
        `option_d`
    FROM
        `survey_question_answers` WHERE `questionID` =?', [$id]);
    return $questions;
  }
}
