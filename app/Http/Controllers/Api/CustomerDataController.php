<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerDataTableResource;
use App\Models\customers;

class CustomerDataController extends Controller
{
    public function getCustomers()
    {
        $data = customers::with('Area', 'Creator')
            ->whereHas('Area')
            ->whereHas('Creator')
            ->orderBy('id', 'DESC')
            ->get();
        return new CustomerDataTableResource($data);
    }
}
