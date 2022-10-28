<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadsTargets extends Model
{
    use HasFactory;
    protected $table ='leads_targets';
    protected $guarded= [];
}
