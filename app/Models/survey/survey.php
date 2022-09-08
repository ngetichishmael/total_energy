<?php
namespace App\Models\survey;

use Illuminate\Database\Eloquent\Model;

class survey extends Model
{
   protected $table = 'survey';

   /**
    * Get all of the comments for the survey
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function Questions()
   {
       return $this->hasMany(questions::class, 'survey_code', 'code');
   }

}
