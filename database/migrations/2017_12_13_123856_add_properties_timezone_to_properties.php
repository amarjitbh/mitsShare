<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropertiesTimezoneToProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('timezone_name')->after('is_approved_checked');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('properties', function (Blueprint $table) {
             $table->dropColumn('timezone_name');
        });
    }
    
}
