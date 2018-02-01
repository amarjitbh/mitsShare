<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePropertyTypeSectionFeildValuesDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties_field_values', function (Blueprint $table) {
            $table->text('property_type_section_field_value')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties_field_values', function (Blueprint $table) {
            $table->string('property_type_section_field_value',191)->change();
        });
    }
}
