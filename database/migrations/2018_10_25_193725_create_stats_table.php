<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->increments('id');
            // $table->timestamps();
            $table->integer('answers_total')->default(0);
            $table->integer('answers_correct')->default(0);
            $table->integer('answers_wrong')->default(0);
            $table->string('answers_accuracy')->default('0%');
            $table->integer('answers_rating')->default(0);
            $table->integer('user_id')->unsigned();
            $table->integer('trainer_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('trainer_id')->references('id')->on('trainers')->onDelete('cascade');
        });

        $users = \App\User::all();

        foreach ($users as $user) {
            \App\Stats::create(['user_id' =>  $user->id, 'trainer_id' => 1]);
            \App\Stats::create(['user_id' =>  $user->id, 'trainer_id' => 2]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stats');
    }
}
