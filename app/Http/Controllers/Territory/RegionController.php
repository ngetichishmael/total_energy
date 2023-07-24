<?php

namespace App\Http\Controllers\Territory;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Relationship;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response | View
    {
        return view('livewire.territory.region.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $region = Region::create([
            'name' => $request->name,
            'primary_key' => Str::random(20),
        ]);
        Relationship::create([
            'name' => $request->name,
            'has_children' => false,
            'region_id' => $region->id,
            'parent_id' => null,
            'level_id' => 0,
        ]);
        Session()->flash('success', "Region successfully added");
        return redirect()->back();
    }
}
