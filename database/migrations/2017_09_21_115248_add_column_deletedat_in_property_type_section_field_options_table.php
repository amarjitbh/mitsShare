<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDeletedatInPropertyTypeSectionFieldOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('property_type_section_field_options', 'deleted_at')) {
            Schema::table('property_type_section_field_options', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**     * Reverse the migrations.     *     * @return void */
    public function down()
    {
        if (Schema::hasColumn('property_type_section_field_options', 'deleted_at')) {
            Schema::table('property_type_section_field_options', function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
    }
}
