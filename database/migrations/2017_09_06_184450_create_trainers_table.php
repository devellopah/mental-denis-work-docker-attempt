<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTrainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('trainers')->insert(['name' => 'Ментальный счёт']);
        DB::table('trainers')->insert(['name' => 'Флеш-карты']);
        DB::table('users')->insert(['name' => 'Teacher', 'email' => 'teacher@teacher.ru', 'password' => bcrypt('teacher'), 'rang' => 'C']);
        DB::table('users')->insert(['name' => 'Student', 'email' => 'student@student.ru', 'password' => bcrypt('student'), 'rang' => 'E']);

        Schema::table('trainer_task_categories', function (Blueprint $table) {
            $table->integer('trainer_id')->unsigned()->default(1);
            $table->foreign('trainer_id')->references('id')->on('trainers');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->default('default.png');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainers');
    }
}
