<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subarea extends Model
{
   use HasFactory;
   protected $guarded = [""];
   /**
    * Get the Area that owns the Subarea
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Area(): BelongsTo
   {
      return $this->belongsTo(Area::class);
   }
   /**
    * Get all of the Zones for the Subarea
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function Zones(): HasMany
   {
      return $this->hasMany(zone::class);
   }
}
