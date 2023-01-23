<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitRoute extends Model
{
   use HasFactory;
   protected $table = 'unit_routes';
   protected $guarded = [];
   /**
    * Get the Subregion that owns the UnitRoute
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Subregion(): BelongsTo
   {
      return $this->belongsTo(Subregion::class);
   }
}