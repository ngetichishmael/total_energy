<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestionsOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_questions_options', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('questionID');
                $table->string('survey_code');
                $table->text('options_a')->nullable();
                $table->text('options_b')->nullable();
                $table->text('options_c')->nullable();
                $table->text('options_d')->nullable();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_questions_options');
    }
}
