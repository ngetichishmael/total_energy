<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Session;
use Auth;
use Helper;

class usersController extends Controller
{
   //list
   public function index(){
      return view('app.users.index');
   }

   //create
   public function create(){
      return view('app.users.create');
   }

   //store
   public function store(Request $request){
      $this->validate($request,[
         'email' => 'required',
         'name' => 'required',
         'phone_number' => 'required',
         'account_type' => 'required',
      ]);

      //save user
      $user = new User;
      $user->user_code = Helper::generateRandomString(20);
      $user->email = $request->email;
      $user->phone_number = $request->phone_number;
      $user->name = $request->name;
      $user->account_type = $request->account_type;
      $user->status = 'Active';
      $user->password = Hash::make($request->phone_number);
      $user->business_code = Auth::user()->business_code;
      $user->save();

      Session::flash('success','User Created Successfully');

      return redirect()->route('users.index');
   }

   //edit
   public function edit($id){
      $edit = User::where('id',$id)->where('business_code',Auth::user()->business_code)->first();

      return view('app.users.edit', compact('edit'));
   }

   //update
   public function update(Request $request,$id){
      $this->validate($request,[
         'email' => 'required',
         'name' => 'required',
         'phone_number' => 'required',
         'account_type' => 'required',
      ]);

      //save user
      $edit = User::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $edit->email = $request->email;
      $edit->phone_number = $request->phone_number;
      $edit->name = $request->name;
      $edit->account_type = $request->account_type;
      $edit->status = $request->status;
      $edit->password = Hash::make($request->phone_number);
      $edit->admin_id = Auth::user()->id;
      $edit->save();

      Session::flash('success','User updated Successfully');

      return redirect()->back();
   }
}
