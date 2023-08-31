<?php

namespace App\Http\Controllers;

use App\Models\activity_log;
use App\Models\User;
use Livewire\WithPagination;

class ActivityController extends Controller
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $perPage = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('livewire.activity.layout');
    }

    public function sales()
    {
        return view('app.activity.sales');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = activity_log::whereId($id)->first();
        $activities = activity_log::where('user_code', $activity->user_code)->get();
        $user = User::where('user_code', $activity->user_code)->get();
        return view('livewire.activity.view', compact('activity', 'activities', 'user'));
    }
}
