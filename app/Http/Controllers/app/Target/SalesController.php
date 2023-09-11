<?php

namespace App\Http\Controllers\app\Target;

use App\Http\Controllers\Controller;
use App\Models\SalesTarget;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('app.Targets.sales');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('livewire.sales.layout');
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
        return view('livewire.sales.layout-view', [
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
        $edit = SalesTarget::where('user_code', $code)->orderBY('id', 'DESC')->first();
        if (!$edit) {
            $today = Carbon::now(); //Current Date and Time
            $lastDayofMonth = Carbon::parse($today)->endOfMonth()->toDateString();
            SalesTarget::create(
                [
                    'user_code' => $code,
                    'Deadline' => $lastDayofMonth,
                    'SalesTarget' => 0,
                ]
            );
            $edit = SalesTarget::where('user_code', $code)->orderBY('id', 'DESC')->first();
        }
        return view('app.Targets.salesedit', ['edit' => $edit]);
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
        $updatesales = SalesTarget::where('user_code', $code)->first();
        $updatesales->SalesTarget = $request->target;
        $updatesales->Deadline = $request->deadline;
        $updatesales->save();

        Session::flash('success', 'Sales Target Updated!');
        return redirect()->route('sales.target');
    }
}
