<?php

namespace App\Http\Livewire\Territory;

use Livewire\Component;
use App\Models\Territory;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Index extends Component
{
   use WithPagination;
   public $name = "";
   public $status = "";
   public $parent_territory = "";

   public function render()
   {
      $territories =  Territory::whereNUll('parent_code')->get();
      $parents = Territory::where('status','Active')->get();

      return view('livewire.territory.index', compact('territories','parents'));
   }

   //validation
   protected $rules = [
      'name' => 'required',
      'status' => 'required',
   ];

   //add territory
   public function add_territory(){
      $this->validate();

      $territory = new Territory;
      $territory->business_code = FacadesAuth::user()->business_code;
      $territory->code = Str::random(20);
      $territory->name = $this->name;
      $territory->parent_code = $this->parent_territory;
      $territory->status = $this->status;
      $territory->created_by =FacadesAuth::user()->user_code;
      $territory->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Terriory added succesfully"
      ]);

      $this->restFields();
   }

   //reset fiels
   public function restFields(){
      $this->name = "";
      $this->parent_territory = "";
      $this->status = "";
   }
}


