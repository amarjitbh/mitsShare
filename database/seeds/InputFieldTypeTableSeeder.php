<?php

use Illuminate\Database\Seeder;

class InputFieldTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('input_field_types')->truncate();
        DB::table('input_field_types')->insert([
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.1')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.2')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.3')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.4')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.5')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.6')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.7')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.8')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.9')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.10')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.11')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.12')],
            ['field_name' => \Config::get('constants.INPUT_TYPE_FIELD.13')],
        ]);
    }
}
