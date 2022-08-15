<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskCommentsToFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('files_task_comments', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('task_comments_id')->unsigned()->index();
        $table->foreign('task_comments_id')->references('id')->on('task_comments')->onDelete('cascade');
        $table->integer('files_id')->unsigned()->index();
        $table->foreign('files_id')->references('id')->on('files')->onDelete('cascade');

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
        Schema::dropIfExists('files_to_task_comments');
    }
}
