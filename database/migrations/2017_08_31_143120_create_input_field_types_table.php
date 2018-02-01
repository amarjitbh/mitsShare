<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInputFieldTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('input_field_types')) {
                
		Schema::create('input_field_types', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('field_name', 200);
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
		Schema::drop('input_field_types');
	}

}
