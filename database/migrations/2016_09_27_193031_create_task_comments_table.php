<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('task_comments');
        Schema::create(
            'task_comments',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('tasks_id')->unsigned()->index();
                $table->integer('user_id')->unsigned()->index();
                $table->text('description_detail');
                $table->timestamps();

                $table->foreign('tasks_id')->references('id')->on('tasks')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_comments');
    }
}
