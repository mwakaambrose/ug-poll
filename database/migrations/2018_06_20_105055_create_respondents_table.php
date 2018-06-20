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
            $table->bigIncrements('id');
            $table->integer('district_id')->unsigned();
            $table->string('name');
            $table->string('phone_number')->unique();
            $table->string('address');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('email')->nullable();

            $table->timestamps();

            $table->foreign('district_id')->references('id')
                ->on('districts')->onUpdate('cascade')->onDelete('cascade');
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
