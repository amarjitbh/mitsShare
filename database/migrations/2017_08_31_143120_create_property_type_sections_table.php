<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropertyTypeSectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('property_type_sections')) {
                
		Schema::create('property_type_sections', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('property_type_id')->nullable();
			$table->string('name', 45)->nullable();
			$table->smallInteger('order_id')->nullable();
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
		Schema::drop('property_type_sections');
	}

}
