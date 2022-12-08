<?php

namespace Database\Seeders;

use App\Models\AppPermission;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppPermissionSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      $user_codes = User::where('account_type', 'Sales')->get();

      foreach ($user_codes as $code) {
         AppPermission::updateOrCreate(
            [
               "user_code" => $code->user_code,
            ],
            [
               "van_sales" => "YES",
               "new_sales" => "YES",
               "schedule_visits" => "YES",
               "deliveries" => "YES",
               "merchanizing" => "YES",
            ]
         );
      }
   }
}
