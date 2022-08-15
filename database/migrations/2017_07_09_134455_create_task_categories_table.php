<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'task_categories',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');

                $table->timestamps();
            }
        );

        Schema::table(
            'tasks',
            function (Blueprint $table) {
                $table->unsignedInteger('category_id')->index();
                $table->foreign('category_id')->references('id')->on('task_categories');
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
        Schema::dropIfExists('task_categories');
    }
}
