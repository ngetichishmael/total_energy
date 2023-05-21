<?php

namespace App\Jobs;

use App\Models\MKOCustomer;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CrystalCustomer implements ShouldQueue
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
        MKOCustomer::updateOrCreate(
            [
                'customer_name' => $this->value["name"],
            ],
            [
                'odoo_uuid' => $this->value["id"],
                'soko_uuid' => Str::uuid(),
                'source' => 'crystal',
                'company_type' => "Total MKO",
                'type' => $this->value["loccode"],
                'country' => "Kenya",
                'latitude' => 0.00,
                'longitude' => 0.00,
                'route' => "",
                'route_code' => "1",
                'region' => "1",
                'subregion' => "1",
                'zone' => "1",
                'unit' => "1",
                'branch' => $this->value["code"],
                'business_code' => "crystal",
            ]
        );
    }
}
