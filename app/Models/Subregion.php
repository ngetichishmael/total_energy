<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subregion extends Model
{
   use HasFactory;
   protected $table = 'subregions';
   protected $guarded = [];

   /**
    * Get the Region that owns the Subregion
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Region(): BelongsTo
   {
      return $this->belongsTo(Region::class);
   }
   /**
    * Get all of the Zones for the Subregion
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function Zones(): HasMany
   {
      return $this->hasMany(zone::class);
   }
}