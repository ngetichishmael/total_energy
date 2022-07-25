<?php

namespace App\Http\Controllers\app\survey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\survey\survey;
use App\Models\survey\category;
use App\Models\survey\question_type;
use App\Models\survey\questions;
use App\Models\survey\answers;
use Auth;
use Session;
use File;
use Helper;

class questionsController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($code)
   {
      $survey = survey::where('code',$code)->first();
      $questions = questions::join('survey_question_types','survey_question_types.id','=','survey_questions.type')
                           ->where('survey_code',$code)
                           ->orderby('survey_questions.id','desc')
                           ->select('*','survey_questions.id as questionID')
                           ->get();

      return view('app.survey.questions.index', compact('survey','questions'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create($code)
   {
      $survey = survey::where('code',$code)->first();
      $types = question_type::where('status',15)->pluck('name','id')->prepend('choose question type','');
      return view('app.survey.questions.create', compact('survey','types'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request,$id)
   {
      $this->validate($request,[
         'types' => '',
         'questions' => '',
         'correct' => '',
      ]);

      //questions
      $question = new questions;
      // if(!empty($request->image)){
      //    $file = $request->image;
      //    // SET UPLOAD PATH
      //    $destinationPath = base_path().'/public/trivia/questions/';
      //    // GET THE FILE EXTENSION
      //    $extension = $file->getClientOriginalExtension();

      //    // RENAME THE UPLOAD WITH RANDOM NUMBER
      //    $fileName = Helper::generateRandomString(10). '.' . $extension;
      //    // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
      //    $file->move($destinationPath, $fileName);
      //    $question->image = $fileName;
      // }
      $question->survey_code = $id;
      $question->question_code = Helper::generateRandomString(12);
      $question->type = $request->type;
      $question->question = $request->question;
      $question->answer = $request->correct;
      $question->position = 0;
      $question->time = $request->time;
      $question->points = $request->points;
      $question->created_by = Auth::user()->id;
      $question->save();


      //answers
      $answers = new answers;
      $answers->survey_code = $id;
      $answers->questionID = $question->id;
      $answers->option_a = $request->option_a;
      $answers->option_b = $request->option_b;
      $answers->option_c = $request->option_c;
      $answers->option_d = $request->option_d;
      $answers->correct = $request->correct;
      $answers->created_by = Auth::user()->id;
      $answers->save();

      Session::flash('success','Question successfully added');

      return redirect()->route('survey.questions.index',$id);
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($triviaID,$id)
   {
      $survey = survey::where('code',$triviaID)->first();
      $question = questions::find($id);
      $answers = answers::where('questionID',$id)->first();
      $types = question_type::where('status',15)->pluck('name','id')->prepend('choose question type','');

      return view('app.survey.questions.edit', compact('survey','question','answers','types'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $triviaID, $questionID)
   {
      $this->validate($request,[
         'types' => '',
         'questions' => '',
      ]);

      if($request->type == 1){
         $this->validate($request,[
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => '',
         ]);
      }
      if($request->type == 2){
         $this->validate($request,[
            'true' => '',
            'false' => '',
            'true_false_answer' => '',
         ]);
      }

      //questions
      $question = questions::find($questionID);
      if($question->question_code == ""){
         $question->question_code = Helper::generateRandomString(12);
      }
      if(!empty($request->image)){
         $file = $request->image;
         // SET UPLOAD PATH
         $destinationPath = base_path().'/public/trivia/questions/';
         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();

         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(10). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($destinationPath, $fileName);
         $question->image = $fileName;
      }
      $question->survey_code = $triviaID;
      $question->type = $request->type;
      $question->question = $request->question;
      if($request->type == 1){
         $question->answer = $request->correct_answer;
      }
      if($request->type == 2){
         $question->answer = $request->true_false_answer;
      }
      $question->position = 0;
      $question->time = $request->time;
      $question->points = $request->points;
      $question->updated_by = Auth::user()->id;
      $question->save();


      //answers
      $answers = answers::find($request->answerID);
      $answers->survey_code = $triviaID;
      $answers->questionID = $questionID;
      if($request->type == 1){
         $answers->option_a = $request->option_a;
         $answers->option_b = $request->option_b;
         $answers->option_c = $request->option_c;
         $answers->option_d = $request->option_d;
         $answers->correct = $request->correct_answer;
      }
      if($request->type == 2){
         $answers->option_a = $request->true;
         $answers->option_b = $request->false;
         $answers->correct = $request->true_false_answer;
      }
      $answers->updated_by = Auth::user()->id;
      $answers->save();

      Session::flash('success','Question successfully updated');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      //
   }
}
