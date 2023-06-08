<?php

namespace App\Http\Controllers;

use App\Models\MeasurementUnit;
use App\Http\Requests\StoreMeasurementUnitRequest;
use App\Http\Requests\UpdateMeasurementUnitRequest;

class MeasurementUnitController extends Controller
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
     * @param  \App\Http\Requests\StoreMeasurementUnitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMeasurementUnitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function show(MeasurementUnit $measurementUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(MeasurementUnit $measurementUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMeasurementUnitRequest  $request
     * @param  \App\Models\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMeasurementUnitRequest $request, MeasurementUnit $measurementUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(MeasurementUnit $measurementUnit)
    {
        //
    }
}
