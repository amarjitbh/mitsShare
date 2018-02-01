<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropertyAvailaibilityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('property_availaibility')) {
                
		Schema::create('property_availaibility', function(Blueprint $table)
		{
			$table->unsignedInteger('id', true);
			$table->unsignedInteger('property_id');
			$table->unsignedTinyInteger('avalaibility_option');
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
		Schema::drop('property_availaibility');
	}

}
