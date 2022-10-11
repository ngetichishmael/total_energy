<?php
namespace App\Models\customer;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class checkin extends Model
{
   Protected $table = 'customer_checkin';
   public $guarded = [];

   public function getTimeAgoAttribute()
{
   $endTime = Carbon::parse($this->start_time);
   $startTime = Carbon::parse($this->stop_time);
   $timeleft = $startTime->diffAsCarbonInterval($endTime);
    return $timeleft;
}
}
