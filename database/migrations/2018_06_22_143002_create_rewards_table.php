<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('phone_number');
            $table->integer('survey_id')->unsigned();
            $table->string('amount');
            $table->string('error_message');
            $table->string('requestId');
            $table->foreign('survey_id')->references('id')->on('surveys')->onUpdate('cascade')->onDelete('cascade'); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rewards');
    }
}
