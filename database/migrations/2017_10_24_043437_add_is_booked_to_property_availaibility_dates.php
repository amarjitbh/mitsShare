<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsBookedToPropertyAvailaibilityDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_availaibility_dates', function($table) {
            $table->boolean('is_booked')->comment = "0->Not Booked, 1->Booked";
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
            $table->dropColumn('is_booked');
        });
    }
}
