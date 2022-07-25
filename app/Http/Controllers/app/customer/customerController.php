<?php
namespace App\Http\Controllers\app\customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\customer\customers;
use App\Models\customer\contact_persons;
use App\Models\country;
use App\Models\customer\groups;
use App\Models\customer\customer_group;
use File;
use Helper;
use Session;
use Auth;

class customerController extends Controller{

	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
      $contacts = customers::join('business','business.business_code','=','customers.business_code')
            ->where('customers.business_code',Auth::user()->business_code)
            ->select('*','customers.id as customerID','customers.created_at as date_added','business.business_code as business_code','customers.business_code as business_code','customers.email as customer_email','customers.phone_number as phone_number')
            ->OrderBy('customers.id','DESC')
            ->paginate(50);
      $count = 1;

		return view('app.customers.index', compact('count','contacts'));
	}

	public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$groups = groups::where('businessID',Auth::user()->business_code)->OrderBy('id','DESC')->pluck('name','id');
		return view('app.customers.create', compact('country','groups'));
	}

	public function store(Request $request){
		$this->validate($request, [
			'customer_name' => 'required',
         'account' => 'required',
		]);

 		$customer = new customers;
 		$customer->customer_name = $request->customer_name;
      $customer->account = $request->account;
      $customer->manufacturer_number = $request->manufacturer_number;
      $customer->vat_number = $request->vat_number;
      $customer->delivery_time = $request->delivery_time;
      $customer->address = $request->address;
      $customer->city = $request->city;
      $customer->province = $request->province;
      $customer->postal_code = $request->postal_code;
      $customer->country = $request->country;
      $customer->latitude = $request->latitude;
      $customer->longitude = $request->longitude;
      $customer->contact_person = $request->contact_person;
      $customer->telephone = $request->telephone;
      $customer->customer_group = $request->customer_group;
      $customer->customer_secondary_group = $request->customer_secondary_group;
      $customer->price_group = $request->price_group;
      $customer->route = $request->route;
      $customer->branch = $request->branch;
      $customer->email = $request->email;
      $customer->phone_number = $request->phone_number;
		$customer->business_code = Auth::user()->business_code;
		$customer->created_by = Auth::user()->id;
 		$customer->save();

	   Session::flash('success','Customer successfully Added');

	   return redirect()->route('customer.index');
 	}

 	public function edit($id){
 		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
 		$customer = customers::where('customers.id',$id)
						->select('*','customers.id as customerID')
						->first();
 		return view('app.customers.edit', compact('customer','country'));
 	}

 	public function update(Request $request, $id){
		$this->validate($request, [
			'customer_name' => 'required'
		]);

		$customer = customers::where('id',$id)->first();
 		$customer->customer_name = $request->customer_name;
      $customer->account = $request->account;
      $customer->manufacturer_number = $request->manufacturer_number;
      $customer->vat_number = $request->vat_number;
      $customer->delivery_time = $request->delivery_time;
      $customer->address = $request->address;
      $customer->city = $request->city;
      $customer->province = $request->province;
      $customer->postal_code = $request->postal_code;
      $customer->country = $request->country;
      $customer->latitude = $request->latitude;
      $customer->longitude = $request->longitude;
      $customer->contact_person = $request->contact_person;
      $customer->telephone = $request->telephone;
      $customer->customer_group = $request->customer_group;
      $customer->customer_secondary_group = $request->customer_secondary_group;
      $customer->price_group = $request->price_group;
      $customer->route = $request->route;
      $customer->branch = $request->branch;
      $customer->email = $request->email;
      $customer->phone_number = $request->phone_number;
		//$customer->businessID = Auth::user()->business_code;
		$customer->updated_by = Auth::user()->id;
 		$customer->save();

        //recorord activity
		$activities = '<b>'.Auth::user()->name.'</b> Has <b>updated</b><i> '.$request->customer_name.'</i> details';
		$section = 'Customer';
		$action = 'Update';
      $businessID = Auth::user()->business_code;
		$activityID = $customer->id;

		Helper::activity($activities,$section,$action,$activityID,$businessID);

 		Session::flash('success','Customer updated successfully');

	   return redirect()->back();
 	}



	 //delete permanently
	public function delete($id){

		//check if user is linked to any module
		//invoice
		$invoice = invoices::where('businessID',Auth::user()->business_code)->where('customerID',$id)->count();

		//credit note
		$creditnote = creditnote::where('businessID',Auth::user()->business_code)->where('customerID',$id)->count();

		//quotes
		$quotes = quotes::where('businessID',Auth::user()->business_code)->where('customerID',$id)->count();

		//project
		$project = project::where('businessID',Auth::user()->business_code)->where('customerID',$id)->count();

		if($invoice == 0 && $creditnote == 0 && $quotes == 0 && $project == 0){

			//client info
			$check = customers::where('id','=',$id)->where('image','!=', "")->count();
			if ($check > 0){
				$deleteinfo = customers::where('id','=',$id)->select('image','customer_code')->first();

				$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->businessID.'/customer/'.$deleteinfo->customer_code.'/images/';

				$delete = $path.$deleteinfo->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			//delete contact person
			$persons = contact_persons::where('customerID',$id)->get();
			foreach ($persons as $person) {
				$person->delete();
			}

			//delete contact
			customers::where('id','=',$id)->delete();

			//delete address
			address::where('customerID',$id)->delete();

			//delete company group
			$check_group = customer_group::where('customerID',$id)->count();
			if($check_group > 0){
				$groups = customer_group::where('customerID',$id)->get();
				foreach($groups as $group){
					$deleteGroup = customer_group::find($group->id);
					$deleteGroup->delete();
				}
			}

			Session::flash('success','Contact was successfully deleted');

			return redirect()->route('finance.contact.index');
		}else{
			Session::flash('error','You have recorded transactions for this contact. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}


   public function express_store(Request $request){
      $primary = new customers;
		$primary->customer_name = $request->customer_name;
		$primary->email = $request->email;
		$primary->primary_phone_number = $request->phone_number;
      $primary->businessID = Auth::user()->business_code;
      $primary->created_by = Auth::user()->id;
		$primary->save();

		$address = new address;
		$address->customerID = $primary->id;
		$address->save();

   }

   public function express_list()
   {
      $accounts = customers::where('businessID',Auth::user()->business_code)->orderby('id','desc')->get(['id', 'customer_name as text']);
      return ['results' => $accounts];
   }
}
