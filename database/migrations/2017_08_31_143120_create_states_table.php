<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('states')) {
                
		Schema::create('states', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->smallInteger('country_id');
			$table->string('state_name', 100);
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
		Schema::drop('states');
	}

}
