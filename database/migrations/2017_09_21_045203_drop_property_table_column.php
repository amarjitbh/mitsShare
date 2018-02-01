<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPropertyTableColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('property_type_section_field_id');
            $table->dropColumn('property_type_section_field_value');
            $table->dropColumn('is_option');
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
            $table->integer('property_type_section_field_id');
            $table->string('property_type_section_field_value');
            $table->boolean('is_option');
        });

    }
}
