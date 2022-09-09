<?php
namespace App\Models\survey;

use App\Models\survey_questions_options;
use Illuminate\Database\Eloquent\Model;

class questions extends Model
{
   protected $table = 'survey_questions';
   /**
    * Get the user that owns the questions
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function Survey()
   {
       return $this->belongsTo(survey::class, 'code', 'survey_code');
   }
   /**
    * Get the user that owns the questions
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function type()
   {
       return $this->belongsTo(question_type::class, 'type', 'id');
   }
   /**
    * Get the answers associated with the questions
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function answers()
   {
       return $this->hasOne(answers::class, 'id', 'questionID');
   }
   /**
    * Get the Option associated with the questions
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function options()
   {
       return $this->hasOne(survey_questions_options::class, 'survey_code', 'options');
   }
}
