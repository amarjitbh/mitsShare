<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePropertyAvailaibilityDatatype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_availaibility', function (Blueprint $table) {
            $table->integer('avalaibility_option')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_availaibility', function (Blueprint $table) {
            $table->unsignedInteger('avalaibility_option',191)->change();
        });
    }
}
