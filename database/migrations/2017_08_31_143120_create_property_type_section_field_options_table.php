<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropertyTypeSectionFieldOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('property_type_section_field_options')) {
		Schema::create('property_type_section_field_options', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('property_type_section_field_id')->nullable();
			$table->smallInteger('order_id')->nullable();
			$table->string('display_value', 50)->nullable();
			$table->timestamps();
                        $table->softDeletes();
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
		Schema::drop('property_type_section_field_options');
	}

}
