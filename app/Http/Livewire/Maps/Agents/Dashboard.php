<?php

namespace App\Http\Livewire\Maps\Agents;

use App\Models\CurrentDeviceInformation;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
   public string $typeMap = 'roadmap';
   public function render()
   {
      $information = CurrentDeviceInformation::orderBy('id', 'ASC')->get();
      $data = $information->groupBy('user_code');
      foreach ($data as $value) {
         // dd($value);
         $initialMarkers = [];
         foreach ($value as $info) {
            $myArray = explode(',', $info['current_gps']);
            $array = [
               'title' => User::where('user_code', $info->user_code)->pluck('name')->implode(''),
               'user_code' => $info->user_code,
               'lat' => $myArray[0],
               'lng' => $myArray[1],
               'position' => [
                  'lat' => (float)$myArray[0],
                  'lng' => (float)$myArray[1],
               ],
               'battery' => $info->current_battery_percentage,
               'android_version' => $info->android_version,
               'IMEI' => $info->IMEI,
               'description' => $info->updated_at->diffForHumans(),
            ];
            array_push($initialMarkers, $array);
         }
      }
      return view('livewire.maps.agents.dashboard', [
         'initialMarkers' => $initialMarkers
      ]);
   }
}