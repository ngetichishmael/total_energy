<?php

namespace App\Exports;

use App\Models\SurveyResponses;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ResponsesExport implements FromView
{

   /**
    * @return \Illuminate\Support\FromView
    */
   public function view(): View
   {

      return view('Exports.responses', [
         'responses' => SurveyResponses::all()
      ]);
   }
}
