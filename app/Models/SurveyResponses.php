<?php

namespace App\Models;

use App\Models\survey\survey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyResponses extends Model
{
   use HasFactory;
   protected $table = 'survey_responses';

   protected $guarded = [""];

   /**
    * Get the Customer that owns the SurveyResponses
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Customer(): BelongsTo
   {
      return $this->belongsTo(customers::class, 'customer_id', 'id');
   }
   /**
    * Get the Survery that owns the SurveyResponses
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Survey(): BelongsTo
   {
      return $this->belongsTo(survey::class, 'survey_code', 'code');
   }
   /**
    * Get the Question that owns the SurveyResponses
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Question(): BelongsTo
   {
      return $this->belongsTo(questions::class, 'question_code', 'question_code');
   }
}
