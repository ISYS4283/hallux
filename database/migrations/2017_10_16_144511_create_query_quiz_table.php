<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueryQuizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('query_quiz', function (Blueprint $table) {
            $table->timestamps();

            $table->tinyInteger('points')->default(1);

            $table->unsignedInteger('query_id');
            $table->foreign('query_id')->references('id')->on('queries');

            $table->unsignedInteger('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quizzes');

            $table->primary(['query_id', 'quiz_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('query_quiz');
    }
}
