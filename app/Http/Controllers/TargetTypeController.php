<?php

namespace App\Http\Controllers;

use App\Models\TargetType;
use App\Http\Requests\StoreTargetTypeRequest;
use App\Http\Requests\UpdateTargetTypeRequest;

class TargetTypeController extends Controller
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
     * @param  \App\Http\Requests\StoreTargetTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTargetTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TargetType  $targetType
     * @return \Illuminate\Http\Response
     */
    public function show(TargetType $targetType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TargetType  $targetType
     * @return \Illuminate\Http\Response
     */
    public function edit(TargetType $targetType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTargetTypeRequest  $request
     * @param  \App\Models\TargetType  $targetType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTargetTypeRequest $request, TargetType $targetType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TargetType  $targetType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TargetType $targetType)
    {
        //
    }
}
