<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedRegion extends Model
{
    use HasFactory;
    protected $table = "assigned_regions";
    protected $guarded = [''];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_code', 'user_code');
    }

}
