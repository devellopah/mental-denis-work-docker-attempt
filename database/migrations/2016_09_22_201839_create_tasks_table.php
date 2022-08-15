<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateTasksTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('tasks');

      Schema::create('tasks', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('creator_id')->unsigned();
        $table->integer('executor_id')->unsigned();
        $table->string('name');
        $table->text('description_short');
        $table->text('description_detail');
        $table->timestamps();
        $table->timestamp('starting_at')->nullable();
        $table->timestamp('expires_at')->nullable();
        $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('executor_id')->references('id')->on('users')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('tasks');
    }
  }
