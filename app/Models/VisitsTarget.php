<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitsTarget extends Model
{
    use HasFactory;
    protected $table ='visits_targets';
    protected $guarded= [];
}
