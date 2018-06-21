<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('question_id')->unsigned();
            $table->integer('respondent_id')->unsigned();
            $table->string('phone_number');
            $table->string('status');
            $table->string('cost');

            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('respondent_id')->references('id')->on('respondents')->onUpdate('cascade')->onDelete('cascade');       

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outboxes');
    }
}
