<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsRequestToAvailabilityDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_availaibility_dates', function($table) {
            $table->boolean('is_requested')->comment = "0->No Request For Date, 1->Request For Date";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_availaibility_dates', function($table) {
            $table->dropColumn('is_requested');
        });
    }
}
