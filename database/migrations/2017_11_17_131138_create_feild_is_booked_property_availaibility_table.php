<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeildIsBookedPropertyAvailaibilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_availaibility', function($table) {
            $table->tinyInteger('is_blocked')->after('avalaibility_option');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_availaibility', function($table) {

            $table->dropColumn('is_booked');
        });
    }
}
