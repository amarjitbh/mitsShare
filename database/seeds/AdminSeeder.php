<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('users')->truncate();
        /*DB::table('users')->insert([
            'first_name' => 'admin',
            'last_name' => 'web',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin@123'),
            'is_verified' => 1,
            'role' => 1,
        ]);*/
        DB::table('users')->delete();
        DB::table('users')->insert(array(
            array('first_name'=>'admin','last_name'=>'web','email' => 'admin@gmail.com', 'mobile_number'=>'8888888888','password' => bcrypt('admin@123'),'is_verified' => 1,'role' => 1),
            array('first_name'=>'Jorge','last_name'=>'Seller','email' => 'seller@gmail.com', 'mobile_number'=>'9999999999','password' => bcrypt('seller@123'),'is_verified' => 1,'role' => 2),
        ));

    }
}
