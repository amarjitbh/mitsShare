<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropertyAvailaibilityDatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();
                if (!Schema::hasTable('property_availaibility_dates')) {
                
		Schema::create('property_availaibility_dates', function(Blueprint $table)
		{
			$table->unsignedBigInteger('id', true);
			$table->unsignedInteger('property_availaibility_id');
			$table->foreign('property_availaibility_id')->references('id')->on('property_availaibility');
			$table->date('date');
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
		Schema::drop('property_availaibility_dates');
	}

}
