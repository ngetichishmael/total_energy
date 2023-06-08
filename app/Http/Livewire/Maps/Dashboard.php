<?php

namespace App\Http\Livewire\Maps;

use App\Models\customers;
use Livewire\Component;

class Dashboard extends Component
{
   public string $typeMap = 'roadmap';
   public function render()
   {
      $initialMarkers = [];
      $customers = customers::whereNotNull('latitude')
         ->whereNotNull('longitude')
         ->get();
      foreach ($customers as $data) {
         $array =
            [
               'position' => [
                  'lat' => (float)$data['latitude'],
                  'lng' => (float)$data['longitude'],
               ],
               'id' => $data['id'],
               'customer_name' => $data['customer_name'],
               'account' => $data['account'],
               'approval' => $data['approval'],
               'address' => $data['address'],
               'contact_person' => $data['contact_person'],
               'customer_group' => $data['customer_group'],
               'price_group' => $data['price_group'],
               'route' => $data['route'],
               'status' => $data['status'],
               'email' => $data['email'],
               'phone_number' => $data['phone_number'],

            ];
         array_push($initialMarkers, $array);
      }
      return view('livewire.maps.dashboard', [
         'initialMarkers' => json_encode($initialMarkers)
      ]);
   }
}
