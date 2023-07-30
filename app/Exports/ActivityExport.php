<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ActivityExport implements FromView
{
   protected $array;

   public function __construct($array)
   {
      $this->array = $array;
   }
   /**
    * @return \Illuminate\Support\FromView
    */
   public function view(): View
   {
      return view('Exports.activity', [
         'activities' => $this->array
      ]);
   }
}
