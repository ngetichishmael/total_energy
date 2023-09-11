<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{
   public function render()
   {
     /* $usercount = User::whereNotNull('user_code')
         ->where('route_code', '=', Auth::user()->route_code)
         ->select('account_type', DB::raw('COUNT(*) as count'))
         ->groupBy('account_type')
         ->get(): */
      return view('livewire.user.dashboard', ['usercount' => $this->data()]);
   }
   public function data()
   {
      
       return User::whereNotNull('user_code')->where('route_code', '=', Auth::user()->route_code)->select('account_type', DB::raw('COUNT(*) as count'))
             ->groupBy('account_type')
             ->get();
   }
   public function export()
   {
       return Excel::download(new UsersExport(), 'users.xlsx');
   }

   public function exportCSV()
   {
       return Excel::download(new UsersExport(), 'users.csv');
   }

   public function exportPDF()
   {
       $data = [
           'users' => $this->data(),
       ];

       $pdf = Pdf::loadView('Exports.users_pdf', $data);

       // Add the following response headers
       return response()->streamDownload(function () use ($pdf) {
           echo $pdf->output();
       }, 'users.pdf');
   }
}
