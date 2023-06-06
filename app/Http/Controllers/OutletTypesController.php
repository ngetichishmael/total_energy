<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutletTypeRequest;
use App\Models\OutletType;
use Illuminate\Http\Request;

class OutletTypesController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      return view('livewire.outlet.index');
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(OutletTypeRequest $request)
   {
      OutletType::create($request->validated());

      Session()->flash('success', "Outlet successfully added");
      return redirect()->back();
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($outlet_code)
   {
      $edit = OutletType::where('outlet_code',$outlet_code)->first();
      return view('app.outlets.edit',['edit'=>$edit]);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $outlet_code)
   {
      $update = OutletType::find($outlet_code);
      $update->outlet_name = $request->outlet_name;
      $update->save();

      Session()->flash('success', "Outlet successfully Updated");
      return redirect()->route('outlets');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($outlet_code)
   {
      OutletType::where('outlet_code', $outlet_code)->delete();
      Session()->flash('success', "Successfully Deleted Outlet");
      return redirect()->route('outlets');
   }
}
