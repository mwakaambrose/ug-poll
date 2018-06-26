<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration
{

    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned();
            $table->string('amount');
            $table->string('requestId');
            $table->string('phone_number');
            $table->string('error_message');
            $table->timestamps();
            $table->foreign('survey_id')->references('id')->on('surveys')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rewards');
    }
}
