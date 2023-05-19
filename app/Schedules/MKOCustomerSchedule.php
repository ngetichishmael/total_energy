<?php

namespace App\Schedules;

use App\Jobs\MKOCustomer;
use Illuminate\Support\Facades\Http;

class MKOCustomerSchedule
{
   public function __invoke()
   {
      $object = (object)[];
      $response = Http::withBody(json_encode($object), 'application/json')->get(env('MKO_CUSTOMER'));
      $result = $response->json('result');
      foreach ($result["data"] as $value) {
         MKOCustomer::dispatch($value);
      }
   }
}
