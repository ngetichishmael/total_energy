<?php

namespace App\Http\Livewire\Brands;

use App\Models\products\brand;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
    public function render()
    {

      $brands = brand::where('business_code',Auth::user()->business_code)->orderBy('id','desc')->paginate(10);
        return view('livewire.brands.index',[
         'brands'=>$brands,
        ]);
    }
}
