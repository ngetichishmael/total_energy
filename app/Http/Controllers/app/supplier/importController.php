<?php

namespace App\Http\Controllers\app\finance\supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\suppliers\category;
use App\Imports\suppliers as import;
use App\Exports\suppliers as export;
use Session;
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
   public function index(){
      //check if user is linked to a business and allow access
      $groups = category::OrderBy('id','DESC')->where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose category','');
      return view('app.finance.suppliers.import', compact('groups'));
   }

   /**
    * store uploaded file
   *
   * @return \Illuminate\Http\Response
   */
   public function import(Request $request){
      $this->validate($request, [
         'upload_import' => 'required'
      ]);

      if($request->hasFile('upload_import')){
         
         $file = request()->file('upload_import');

         Excel::import(new import, $file);
   
         Session::flash('success', 'File imported Successfully.');   

         return redirect()->route('finance.supplier.index');
      }else{

         Session::flash('warning','There is no file to import');

         return redirect()->back();
      }
   }


   /**
    * download contacts to excel
   *
   * @return \Illuminate\Http\Response
   */
   public function export(){
      return Excel::download(new export, 'suppliers.xlsx');
   }

   /**
    * download sample csv
   *
   * @return \Illuminate\Http\Response
   */
   public function download_import_sample(){

      $file= public_path(). "/samples/supplier_import_sample_file.csv";

      return response()->download($file);
   }

}
