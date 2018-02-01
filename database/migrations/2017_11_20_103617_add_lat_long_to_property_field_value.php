<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLongToPropertyFieldValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties_field_values', function($table) {
            $table->double('lat')->after('property_type_section_field_value');
            $table->double('long')->after('property_type_section_field_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties_field_values', function($table) {
            $table->double('lat');
            $table->double('long');
        });
    }
}
