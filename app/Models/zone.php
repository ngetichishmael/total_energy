<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class zone extends Model
{
   use HasFactory;
   protected $table = 'zones';
   protected $guarded = [];

   /**
    * Get the Subregion that owns the zone
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Subarea(): BelongsTo
   {
      return $this->belongsTo(Subarea::class);
   }
   /**
    * Get all of the UnitRoutes for the zone
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function UnitRoutes(): HasMany
   {
      return $this->hasMany(UnitRoute::class);
   }
}
