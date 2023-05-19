<?php

namespace App\Schedules;

use App\Jobs\CrystalCustomer;
use Illuminate\Support\Facades\Http;

class CrystalCustomerSchedule
{
    public function __invoke()
    {
        $response = Http::get(env('CRYSTAL_BASE_URL') . '/apis/customers/customers.php');
       $data =$response->json();
       foreach ($data as $user) {
           CrystalCustomer::dispatch($user);
       }
    }
}
