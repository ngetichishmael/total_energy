<?php
namespace App\Models\survey;

use Illuminate\Database\Eloquent\Model;

class answers extends Model
{
   protected $table = 'survey_question_answers';

   /**
    * Get the user associated with the answers
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function questions()
   {
       return $this->hasOne(questions::class, 'survey_code', 'survey_code');
   }
}
