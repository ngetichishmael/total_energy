<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponses extends Model
{
    use HasFactory;
    protected $table = 'survey_responses';

    protected $fillable = [
        'survey_code',
        'question_code',
        'customer_id',
        'answer',
        'reason',
    
    ];

}
