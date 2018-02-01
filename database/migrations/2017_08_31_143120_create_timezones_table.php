<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimezonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('timezones')) {
                
		Schema::create('timezones', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->smallInteger('country_id');
			$table->string('timezone_name', 200);
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
		Schema::drop('timezones');
	}

}
