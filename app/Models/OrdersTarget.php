<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersTarget extends Model
{
    use HasFactory;
    protected $table ='orders_targets';
    protected $guarded= [];
}
