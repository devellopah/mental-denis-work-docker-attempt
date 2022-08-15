<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDialogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('dialog');
        Schema::create(
            'dialog',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('owner_id')->unsigned()->index();
                $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
                $table->integer('respondent_id')->unsigned()->index();
                $table->foreign('respondent_id')->references('id')->on('users')->onDelete('cascade');

                $table->timestamps();
            }
        );
        Schema::dropIfExists('message');
        Schema::create(
            'message',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('owner_id')->unsigned()->index();
                $table->integer('respondent_id')->unsigned()->index();
                $table->integer('dialog_id')->unsigned()->index();
                $table->foreign('dialog_id')->references('id')->on('dialog')->onDelete('cascade');
                $table->text('message_text');
                $table->timestamps();
            }
        );

        Schema::table(
            'dialog',
            function (Blueprint $table) {
                $table->foreign('id')->references('dialog_id')->on('message');
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
        Schema::dropIfExists('dialog');
        Schema::dropIfExists('message');
    }
}
