<?php

namespace App\Http\Controllers\app\Target;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VisitsTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class VisitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('app.Targets.visits');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('livewire.visits.layout');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_code): View
    {
        $name = User::where('user_code', $user_code)->pluck('name')->implode('');
        return view('livewire.visits.layout-view', [
            'user_code' => $user_code,
            'name' => $name,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($code): View
    {
        $edit = VisitsTarget::where('user_code', $code)->orderBY('id', 'DESC')->first();
        if (!$edit) {
            $today = Carbon::now(); //Current Date and Time
            $lastDayofMonth = Carbon::parse($today)->endOfMonth()->toDateString();
            VisitsTarget::Create(
                [
                    'user_code' => $code,
                    'Deadline' => $lastDayofMonth,
                    'VisitsTarget' => 0,
                ]
            );
            $edit = VisitsTarget::where('user_code', $code)->orderBY('id', 'DESC')->first();
        }
        return view('app.Targets.visitsedit', ['edit' => $edit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        $this->validate($request, [
            'target' => 'required',
            'deadline' => 'required',
        ]);
        $updatesales = VisitsTarget::where('user_code', $code)->orderBY('id', 'DESC')->first();
        $updatesales->VisitsTarget = $request->target;
        $updatesales->Deadline = $request->deadline;
        $updatesales->save();

        Session::flash('success', 'Visits Target Updated!');
        return redirect()->route('visit.target');
    }
}
