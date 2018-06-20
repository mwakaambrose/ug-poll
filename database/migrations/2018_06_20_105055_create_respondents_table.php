<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreaterespondentsTable extends Migration
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
            $table->timestamps();
            $table->string('name');
            $table->string('phone_number')->unique();
            $table->string('address');
            $table->string('gender');
            $table->string('email_adress')->nullable();
            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('group_respondant', function (Blueprint $table) {
            $table->timestamps();
            $table->integer('respondant_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->foreign('respondant_id')->references('id')->on('respondents')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['group_id','respondant_id']);
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
