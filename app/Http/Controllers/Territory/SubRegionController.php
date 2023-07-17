<?php

namespace App\Http\Controllers\Territory;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Relationship;
use App\Models\Subregion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SubRegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response | View
    {
        return view('livewire.territory.sub-region.index', [
            'regions' => Region::all(),
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
        $this->validate($request, [
            'name' => 'required',
            'region' => 'required',
        ]);
        $subregion = Subregion::create([
            'region_id' => $request->region,
            'name' => $request->name,
            'primary_key' => Str::random(20),
        ]);
        $region = Region::whereId($request->region)->first();
        Relationship::create([
            'name' => $request->name,
            'has_children' => false,
            'region_id' => $subregion->region_id,
            'parent_id' => $request->region,
            'level_id' => 1,
        ]);
        Relationship::where('name', $region->name)->update([
            'has_children' => true,
        ]);
        Session()->flash('success', "Sub region successfully added");
        return redirect()->back();
    }

}
