<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EWallet;
use Illuminate\Http\Request;

class EWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ewallet = EWallet::UpdateOrCreate(
            [
                'customer_id' => $request->customer_id,
            ],
            [
                'amount' => $request->amount,
            ]);
        return response()->json([
            'ewallet' => $ewallet,
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
        $ewallet = EWallet::whereId($id)->get();
        return response()->json([
            'ewallet' => $ewallet,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ewallet = EWallet::whereId($id)->update([
            'customer_id' => $request->customer_id,
            'amount' => $request->amount,
        ]);
        return response()->json([
            'ewallet' => $ewallet,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json([
            'data' => EWallet::whereId($id)->delete(),
        ]);
    }
}
