<?php

namespace App\Http\Controllers;

use App\Models\UserTargetGroup;
use App\Http\Requests\StoreUserTargetGroupRequest;
use App\Http\Requests\UpdateUserTargetGroupRequest;

class UserTargetGroupController extends Controller
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
     * @param  \App\Http\Requests\StoreUserTargetGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserTargetGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserTargetGroup  $userTargetGroup
     * @return \Illuminate\Http\Response
     */
    public function show(UserTargetGroup $userTargetGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserTargetGroup  $userTargetGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(UserTargetGroup $userTargetGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserTargetGroupRequest  $request
     * @param  \App\Models\UserTargetGroup  $userTargetGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserTargetGroupRequest $request, UserTargetGroup $userTargetGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserTargetGroup  $userTargetGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserTargetGroup $userTargetGroup)
    {
        //
    }
}
