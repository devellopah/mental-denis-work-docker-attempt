<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trainer_id');
            $table->string('trainer_name');
            $table->string('student');
            $table->string('level')->nullable();;
            $table->float('speed')->nullable();;
            $table->string('req_formulas')->nullable();
            $table->string('minmax')->default('от 1 до 9');
            $table->tinyInteger('quantity')->default(10);
            $table->tinyInteger('nums')->nullable();
            $table->boolean('subtraction')->nullable();
            $table->string('started_time')->nullable();
            $table->string('lead_time')->nullable();
            $table->string('points')->default(0);
            $table->string('accuracy')->nullable();
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->boolean('is_finished')->default(0);
            $table->timestamps();
        });

        // нужно выполнить при переносе на сервер
        
        // Schema::table('stats', function (Blueprint $table) {
        //     $table->integer('points')->unsigned()->default(0);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_tasks');
    }
}
