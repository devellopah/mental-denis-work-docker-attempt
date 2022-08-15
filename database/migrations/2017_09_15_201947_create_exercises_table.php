<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::dropIfExists('exercises');

        Schema::create('exercises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('trainer_task_categories')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('trainer_tasks', function (Blueprint $table) {
            $table->string('operation')->nullable();
            // $table->text('examples')->nullable();
            $table->integer('exercise_id')->unsigned();
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
            $table->dropForeign(['category_id']);
            // $table->dropColumn(['category_id', 'numbers_examples', 'operations_examples']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises');

        Schema::table('trainer_task', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('trainer_task_categories');
            $table->dropForeign(['exercise_id']);
            $table->dropColumn(['exercise_id']);
        });

    }
}
