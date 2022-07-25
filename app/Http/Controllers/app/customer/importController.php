<?php

namespace App\Http\Controllers\app\customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\customer\customers;
use App\Models\customer\address;
use App\Models\customer\groups;
use App\Models\customer\customer_group;
use App\Imports\customers as import;
use App\Exports\customers as export;
use Helper;
use Session;
use Wingu;
use Auth;
use Excel;
class importController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
	}

   /**
    * import csv
   *
   * @return \Illuminate\Http\Response
   */
   public function import(){

      return view('app.customers.import');
   }

   /**
    * store uploaded file
   *
   * @return \Illuminate\Http\Response
   */
   public function import_contact(Request $request){
      $this->validate($request, [
         'upload_import' => 'required'
      ]);

      $file = request()->file('upload_import');

		Excel::import(new import, $file);

		Session::flash('success', 'File imported Successfully.');

		return redirect()->route('customer.index');
   }


   /**
    * download contacts to excel
   *
   * @return \Illuminate\Http\Response
   */
   public function export(){
      return Excel::download(new export, 'customers.xlsx');
   }

   /**
    * download sample csv
   *
   * @return \Illuminate\Http\Response
   */
   public function download_import_sample(){
      //PDF file is stored under project/public/download/info.pdf
      $file= public_path(). "/samples/customer_import_sample_file.csv";

      return response()->download($file);
   }

}
