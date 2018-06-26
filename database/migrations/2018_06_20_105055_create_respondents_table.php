<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespondentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respondents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('district_id')->unsigned();
<<<<<<< HEAD:database/migrations/2018_06_20_105055_create_respondents_table.php
=======
            $table->string('gender');
            $table->string('address');
            $table->string('phone_number')->unique();
            $table->string('email_address')->nullable();
            $table->timestamps();

>>>>>>> master:database/migrations/2018_06_20_105055_create_respondents_table.php
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respondents');
    }
}
