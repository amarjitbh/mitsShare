<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlMessageToBeSend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('message_to_be_send', function (Blueprint $table) {
            $table->string('approved_token')->after('email');
            $table->string('url')->after('email');
           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('message_to_be_send', function (Blueprint $table) {
             $table->dropColumn('approved_token');
             $table->dropColumn('url');
             
        });
    }
}
