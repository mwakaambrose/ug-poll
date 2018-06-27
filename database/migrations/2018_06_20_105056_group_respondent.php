<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupRespondent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::create('group_respondent', function (Blueprint $table) {
            $table->timestamps();
            $table->integer('respondent_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->foreign('respondent_id')->references('id')->on('respondents')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['group_id','respondent_id']);    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_respondent');
    }
}
