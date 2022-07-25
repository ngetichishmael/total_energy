<?php
namespace App\Http\Controllers\app\supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\suppliers\suppliers;
use App\Models\expense\expense;
use App\Models\suppliers\contact_persons;
use App\Models\products\product_information;
use App\Models\suppliers\comments;
use App\Models\suppliers\supplier_address;
use App\Models\suppliers\category;
use App\Models\suppliers\suppliers_categories;
use App\Models\country;
use App\Models\lpo\lpo;
use App\Models\invoice\invoices;
use File;
use Helper;
use Session;
use Wingu;
use Auth;

class supplierController extends Controller{

	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$suppliers = suppliers::join('business','business.business_code','=','suppliers.business_code')
							->where('suppliers.business_code',Auth::user()->business_code)
                     ->select('*','suppliers.id as supplierID','suppliers.name as supplier_name','suppliers.email as supplier_email','suppliers.phone_number as phone_number','suppliers.created_at as created_at')
							->OrderBy('suppliers.id','DESC')
							->get();
		$count = 1;

		return view('app.suppliers.index', compact('suppliers','count'));
	}

	public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$groups = category::where('business_code',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('name','id');
		return view('app.suppliers.create', compact('country','groups'));
	}

	public function store(Request $request){
		$this->validate($request, [
			'email' => 'required',
			'phone_number' => 'required',
		]);

		$primary = new suppliers;
		$primary->email = $request->email;
		$primary->name = $request->name;
		$primary->phone_number = $request->phone_number;
		$primary->telephone = $request->telephone;
		$primary->status = $request->status;
		$primary->business_code = Auth::user()->business_code;
		$primary->save();

		Session::flash('success','Supplier has been successfully Added');

		return redirect()->route('supplier.index');
	}

	public function edit($id){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$suppliers = suppliers::where('business_code',Auth::user()->business_code)
						->where('suppliers.id',$id)
                  ->first();
		//category
      $category = category::where('business_code',Auth::user()->business_code)->get();

		return view('app.suppliers.edit', compact('category','suppliers','country'));
	}

	public function update(Request $request, $id){
      $this->validate($request, [
			'email' => 'required',
			'phone_number' => 'required',
		]);

		$edit = suppliers::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
		$edit->email = $request->email;
		$edit->name = $request->name;
		$edit->phone_number = $request->phone_number;
		$edit->telephone = $request->telephone;
		$edit->status = $request->status;
		$edit->business_code = Auth::user()->business_code;
		$edit->save();

		Session::flash('success','Supplier has been successfully updated');

		return redirect()->back();
	}

	//delete permanently
	public function delete($id){

	}
}
