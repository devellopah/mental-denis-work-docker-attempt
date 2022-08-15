<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trainer_id');
            $table->string('trainer_name');
            $table->string('level')->nullable();;
            $table->float('speed')->nullable();;
            $table->string('req_formulas')->nullable();
            $table->string('minmax')->default('от 1 до 9');
            $table->tinyInteger('quantity')->default(10);
            $table->tinyInteger('nums')->nullable();
            $table->boolean('subtraction')->nullable();;
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
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
        Schema::dropIfExists('group_tasks');
    }
}
