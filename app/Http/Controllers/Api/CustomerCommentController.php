<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerCommentRequest;
use App\Http\Requests\UpdateCustomerCommentRequest;
use App\Models\CustomerComment;

class CustomerCommentController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(StoreCustomerCommentRequest $request)
   {
      $comment = CustomerComment::create($request->validated());
      $comment->update([
         'user_id' => $request->user()->id,
      ]);
      return response()->json([
         "success" => true,
         "status" => 200,
         "message" => "comment created successfully",
         "comment" => $comment
      ]);
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      return response()->json([
         "success" => true,
         "status" => 200,
         "message" => "All comments",
         "comment" => CustomerComment::where('customers_id', $id)->get(),
      ]);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(UpdateCustomerCommentRequest $request, $id)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      //
   }
}
