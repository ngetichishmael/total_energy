<?php

namespace App\Http\Resources;

use App\Models\Region;
use App\Models\Subregion;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerDataTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->map(function ($customer) {
            return [
                'id' => $customer->id,
                'customer_name' => $customer->customer_name,
                'address' => $customer->address,
                'group' => $customer->customer_group ?? "Independent Network",
                'creator' => $customer->creator->name,
                'phone_number' => $customer->phone_number,
                'date' => date_format($customer->created_at, 'Y-m-d'),
                'zone' => $this->getRegions($customer->area->name, $customer->area->subregion_id),
            ];
        });
    }
    public function getRegions($name, $subregion_id)
    {
        $subregion = Subregion::whereId($subregion_id)->first();
        $region = Region::whereId($subregion->region_id)->pluck('name')->implode('');
        return $name . ', ' . $subregion->name . ', ' . $region;

    }
}
