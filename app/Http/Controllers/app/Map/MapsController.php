<?php

namespace App\Http\Controllers\app\Map;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MapsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() :Response | View
    {
      return view('livewire.maps.layout');
    }
}
