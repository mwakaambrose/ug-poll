<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('answer')->nullable();
            $table->string('phone_number');//This is the only way we can tell what user thread this is
            $table->integer('outbox_id')->unsigned();//the phone number that has responded, what is its last id in the outbox table, it is the outbox_id here. and then read the next question on the stack after that one at the outbox_id's question_id. [Put the login bit in mind]
            $table->foreign('outbox_id')->references('id')->on('outboxes')->onUpdate('cascade')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inboxes');
    }
}
