<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TargetsSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */

   public function run()
   {
      $today = Carbon::now();
      $lastDayofMonth = Carbon::parse($today)->endOfMonth()->toDateString();
      DB::table('leads_targets')->insert([
         'user_code' => "xtUxiU",
         'LeadsTarget' => '300',
         'Deadline' => $lastDayofMonth,
         'created_at' => now(),
         'updated_at' => now(),
      ]);
      DB::table('visits_targets')->insert([
         'user_code' => "xtUxiU",
         'VisitsTarget' => '400',
         'Deadline' => $lastDayofMonth,
         'created_at' => now(),
         'updated_at' => now(),
      ]);
      DB::table('orders_targets')->insert([
         'user_code' => "xtUxiU",
         'OrdersTarget' => '200000',
         'Deadline' => $lastDayofMonth,
         'created_at' => now(),
         'updated_at' => now(),
      ]);
      DB::table('sales_targets')->insert([
         'user_code' => "xtUxiU",
         'SalesTarget' => '4000000',
         'Deadline' => $lastDayofMonth,
         'created_at' => now(),
         'updated_at' => now(),
      ]);
   }
}
