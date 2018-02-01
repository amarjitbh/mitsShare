<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessgeToBeSend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_to_be_send', function(Blueprint $table)
        {
           $table->increments('id');
            $table->boolean('type');
            $table->string('subject');
            $table->string('body');
            $table->string('email');
            $table->string('mobile_no');
            $table->boolean('is_send')->nullable()->comment('1 for email, 2 for text');
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('message_to_be_send');
    }
}
