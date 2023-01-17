<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyRoute extends Model
{
   use HasFactory;
   protected $table = "company_routes";
   protected $guarded = [""];
   /**
    * Get the user that owns the CompanyRoute
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function user(): BelongsTo
   {
      return $this->belongsTo(User::class, 'route_code', 'route_code');
   }
}
