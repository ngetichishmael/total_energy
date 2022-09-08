<?php
namespace App\Models\survey;

use Illuminate\Database\Eloquent\Model;

class question_type extends Model
{
   protected $table = 'survey_question_types';

   /**
    * Get all of the comments for the question_type
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function questions()
   {
       return $this->hasMany(questions::class, 'type', 'id');
   }
   /**
    * Get the user associated with the question_type
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function answers()
   {
       return $this->hasOne(answers::class,'survey_code','survey_code');
   }
}
