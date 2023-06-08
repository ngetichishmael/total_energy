<?php

namespace App\Http\Controllers;

use App\Models\TargetGroup;
use App\Http\Requests\StoreTargetGroupRequest;
use App\Http\Requests\UpdateTargetGroupRequest;

class TargetGroupController extends Controller
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
     * @param  \App\Http\Requests\StoreTargetGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTargetGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TargetGroup  $targetGroup
     * @return \Illuminate\Http\Response
     */
    public function show(TargetGroup $targetGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TargetGroup  $targetGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(TargetGroup $targetGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTargetGroupRequest  $request
     * @param  \App\Models\TargetGroup  $targetGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTargetGroupRequest $request, TargetGroup $targetGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TargetGroup  $targetGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(TargetGroup $targetGroup)
    {
        //
    }
}
