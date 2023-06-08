<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\customer\customers;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function index()
    {
        $initialMarkers = [];
        $customers = customers::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->limit(50)
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
        return  response()->json(['initialMarkers' => json_encode($initialMarkers)]);
    }
}
