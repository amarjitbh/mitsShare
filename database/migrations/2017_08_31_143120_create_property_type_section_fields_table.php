<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropertyTypeSectionFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('property_type_section_fields')) {
                
		Schema::create('property_type_section_fields', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('property_type_section_id')->nullable();
			$table->string('name', 100)->nullable();
			$table->smallInteger('input_field_type_id')->nullable();
			$table->string('field_identifier', 200)->nullable();
			$table->text('validations', 65535)->nullable();
			$table->smallInteger('allowed_instances')->nullable()->comment('0 for any number and >0 for putting limit');
			$table->smallInteger('order_id')->nullable();
			$table->boolean('is_country')->nullable();
			$table->boolean('is_state')->nullable();
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
		Schema::drop('property_type_section_fields');
	}

}
