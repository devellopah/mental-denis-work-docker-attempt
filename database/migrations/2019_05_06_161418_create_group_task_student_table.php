<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTaskStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_task_student', function (Blueprint $table) {
            $table->increments('id');
            $table->string('started_time')->nullable();
            $table->string('lead_time')->nullable();
            $table->string('points')->default(0);
            $table->string('accuracy')->nullable();
            $table->integer('student_id')->unsigned();
            $table->integer('group_task_id')->unsigned();
            $table->boolean('is_finished')->default(0);
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('group_task_id')->references('id')->on('group_tasks')->onDelete('cascade');
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
        Schema::dropIfExists('group_task_student');
    }
}
