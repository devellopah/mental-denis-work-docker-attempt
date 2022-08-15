<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainerTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('speed')->default(0.5);
            $table->integer('count_examples')->default(20)->nullable();
            $table->integer('minimal_number')->default(0)->nullable();
            $table->integer('maximal_number')->default(100)->nullable();
            $table->text('examples')->nullable();
            $table->integer('sort')->default(100);

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
        Schema::dropIfExists('trainer_tasks');
    }
}
