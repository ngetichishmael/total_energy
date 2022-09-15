<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SurveyResponses as Response;
use Illuminate\Http\Request;

class SurveryAnswersController extends Controller
{
    public function index(Request $request)
    {
        info($request);
        $data = $request->all();
        $response = new Response();
        array_pop($data);
        info($data);
        foreach ($data as $data) {
            $response->survey_code = $data["survey_code"];
            $response->question_code = $data["question_code"];
            $response->customer_id = $data["customer_id"];
            $response->answer = $data["answer"];
            $response->reason = $data["reason"];
            $response->save();
        }
        return response()->json([
            "success" => true,
            "Message" => "Data sent Successfully",
            "Status" => 200
        ]);
    }
}
