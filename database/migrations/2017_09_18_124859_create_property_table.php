<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('properties')) {
                
        Schema::create('properties', function(Blueprint $table)
        {
            $table->integer('id', true);
            $table->integer('property_type_id');
            $table->integer('property_type_section_field_id');
            $table->string('property_type_section_field_value');
            $table->boolean('is_option')->default(0);
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('properties');
    }
}
