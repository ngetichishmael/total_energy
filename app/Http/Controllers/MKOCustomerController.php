<?php

namespace App\Http\Controllers;

use App\Models\MKOCustomer;
use App\Http\Requests\StoreMKOCustomerRequest;
use App\Http\Requests\UpdateMKOCustomerRequest;

class MKOCustomerController extends Controller
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
     * @param  \App\Http\Requests\StoreMKOCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMKOCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MKOCustomer  $mKOCustomer
     * @return \Illuminate\Http\Response
     */
    public function show(MKOCustomer $mKOCustomer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MKOCustomer  $mKOCustomer
     * @return \Illuminate\Http\Response
     */
    public function edit(MKOCustomer $mKOCustomer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMKOCustomerRequest  $request
     * @param  \App\Models\MKOCustomer  $mKOCustomer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMKOCustomerRequest $request, MKOCustomer $mKOCustomer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MKOCustomer  $mKOCustomer
     * @return \Illuminate\Http\Response
     */
    public function destroy(MKOCustomer $mKOCustomer)
    {
        //
    }
}
