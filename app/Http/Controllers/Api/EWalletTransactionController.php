<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EWalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EWalletTransactionController extends Controller
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => ['required', Rule::exists('customers', 'id')],
            'amount' => 'required|numeric',
            'payment_type' => 'required',
        ]);

        $ewallet = EWalletTransaction::create(
            [
                'customer_id' => $validatedData['customer_id'],
                'amount' => $validatedData['amount'],
                'payment_type' => $validatedData['payment_type'],
                'transaction_id' => $request->transaction_id,
                'user_id' => $request->user()->id,
            ]
        );
        return response()->json([
            'EwalletTransacation' => $ewallet,
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
        //
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
