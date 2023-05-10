<?php

namespace App\Jobs;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\MKOCustomer as ModelsMKOCustomer;

class MKOCustomer implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   /**
    * Create a new job instance.
    *
    * @return void
    */
   public $value;
   public function __construct($value)
   {
      $this->value = $value;
   }

   /**
    * Execute the job.
    *
    * @return void
    */
   public function handle()
   {
      ModelsMKOCustomer::updateOrCreate(
         [
            'customer_name' => $this->value["customer_name"],
            'contact_person' => $this->value["contact_person"],
         ],
         [
            'odoo_uuid' => Str::uuid(),
            'soko_uuid' => Str::uuid(),
            'company_type' => $this->value["company_type"],
            'image' => $this->value["image_1920"],
            'telephone' => $this->value["telephone"],
            'mobile' => $this->value["mobile"],
            'email' => $this->value["email"],
            'type' => $this->value["type"],
            'street' => $this->value["street"],
            'city' => $this->value["city"],
            'postal_code' => $this->value["postal_code"],
            'country' => $this->value["country"],
            'latitude' => $this->value["latitude"],
            'longitude' => $this->value["longitude"],
            'manufacturer_number' => $this->value["manufacturer_number"],
            'route' => "1",
            'route_code' => "1",
            'region' => "1",
            'subregion' => $this->value["subregion"],
            'zone' => $this->value["zone"],
            'unit' => $this->value["unit"],
            'branch' => $this->value["branch"],
            'business_code' => $this->value["business_code"],
         ]
      );
   }
}
