<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EWallet;
use App\Models\Orders;
use App\Models\order_payments;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        $validatedData = $request->validate([
            'customer_id' => ['required', Rule::exists('customers', 'id')],
            'amount' => 'required|numeric',
        ]);

        $ewallet = EWallet::updateOrCreate(
            [
                'customer_id' => $validatedData['customer_id'],
            ],
            [
                'amount' => $validatedData['amount'],
            ]
        );

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

        $orders = Orders::where('customerID', $id)->pluck('order_code');

        return response()->json([
            'message' => "Transaction",
            'transaction' => order_payments::whereIn('order_id', $orders)->get(),
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
