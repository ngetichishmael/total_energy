<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EWallet;
use App\Models\EWalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EWalletTransactionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($customer_id)
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
            'payment_type' => 'required',
            'phone_number' => 'required',
        ]);
        $ewalletData = EWallet::updateOrCreate(
            ['customer_id' => $validatedData['customer_id']],
            ['amount' => DB::raw("amount + " . $validatedData['amount'])]
        );

        $ewallet = EWalletTransaction::create(
            [
                'customer_id' => $validatedData['customer_id'],
                'amount' => $validatedData['amount'],
                'payment_type' => $validatedData['payment_type'],
                'phone_number' => $validatedData['phone_number'],
                'transaction_id' => $request->transaction_id,
                'user_id' => $request->user()->id,
            ]
        );
        return response()->json([
            'EWallet' => $ewalletData,
            'EwalletTransacation' => $ewallet,
        ]);

    }

}
