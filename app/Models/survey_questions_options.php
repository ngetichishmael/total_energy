<?php

namespace App\Models;

use App\Models\survey\questions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class survey_questions_options extends Model
{
    use HasFactory;

    protected $table = 'survey_questions_options';
    protected $fillable = [
            'questionID',
            'survey_code',
            'options_a',
            'options_b',
            'options_c',
            'options_d'
     ];

     /**
      * Get the user associated with the survey_questions_options
      *
      * @return \Illuminate\Database\Eloquent\Relations\HasOne
      */
     public function question()
     {
       return $this->hasOne(questions::class,'options','survey_code');
     }
}
