<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedAtColumnInPropertyTypeSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('property_type_sections', 'deleted_at')) {
            Schema::table('property_type_sections', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**     * Reverse the migrations.     *     * @return void */
    public function down()
    {
        if (Schema::hasColumn('property_type_sections', 'deleted_at')) {
            Schema::table('property_type_sections', function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
    }
}
