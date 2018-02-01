<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPolicyIdToBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('bookings', function (Blueprint $table) {
            $table->integer('policy_id')->after('approved_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
          Schema::table('bookings', function (Blueprint $table) {
             $table->dropColumn('policy_id');
        });
    }
}
