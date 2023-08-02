<?php

namespace App\Http\Livewire\Comment;

use App\Models\CustomerComment;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;


use App\Exports\CommentExport;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{

   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public ?string $search = null;
   public function render()
   {
      $searchTerm = '%' . $this->search . '%';
      $comments = CustomerComment::with('User', 'Customer')
         ->search($searchTerm)
         ->orderBy('id', 'DESC')
         ->paginate($this->perPage);
      return view('livewire.comment.dashboard', [
         'comments' => $comments
      ]);
   }

   public function exportPDF()
   {
       $searchTerm = '%' . $this->search . '%';
       $comments = CustomerComment::with('User', 'Customer')
           ->search($searchTerm)
           ->orderBy('id', 'DESC')
           ->get();

       $pdf = PDF::loadView('Exports.comments_pdf', compact('comments'));

       // Download the PDF file
       return response()->streamDownload(function () use ($pdf) {
         echo $pdf->output();
     }, 'customers_comments.pdf');  
   
   }

   public function export()
   {
       return Excel::download(new CommentExport(), 'customer_comments.xlsx');
   }

   public function exportCSV()
   {
       return Excel::download(new CommentExport(), 'customer_comments.csv');
   }
}
