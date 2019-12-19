<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElearningAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elearning_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('result_id')->unsigned()->nullable();
            $table->bigInteger('exam_id')->unsigned()->nullable();
            $table->bigInteger('question_id')->unsigned()->nullable();
            $table->bigInteger('multiple_choice_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('elearning_answers', function (Blueprint $table) {
            $table->foreign('result_id')
                ->references('id')->on('elearning_results')
                ->onDelete('cascade');
            $table->foreign('exam_id')
                ->references('id')->on('elearning_exams')
                ->onDelete('cascade');
            $table->foreign('question_id')
                ->references('id')->on('elearning_questions')
                ->onDelete('cascade');
            $table->foreign('multiple_choice_id')
                ->references('id')->on('elearning_multiple_choices')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elearning_answers');
    }
}
