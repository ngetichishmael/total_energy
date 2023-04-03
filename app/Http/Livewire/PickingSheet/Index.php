<?php

namespace App\Http\Livewire\PickingSheet;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class Index extends Component
{
   public $data;
   public $code;
   public function render()
   {
      return view('livewire.picking-sheet.index', [
         'data' => $this->data,
         'code' => $this->code,
      ]);
   }
   public function download()
   {
      $pdf = Pdf::loadView('Exports.pickingsheet', [
         'data' => $this->data,
         'code' => $this->code,
      ])->setOptions(['defaultFont' => 'sans-serif']);;
      return $pdf->download('pickingsheet.pdf');
   }
}
