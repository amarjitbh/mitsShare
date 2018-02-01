<?php

use Illuminate\Database\Seeder;

class CancellationPolicy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('cancellation_policy')->delete();
         DB::table('cancellation_policy')->insert(array(
         array('policy_name'=>'Flexible','duration'=>'1d','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
         array('policy_name'=>'Moderate','duration'=>'5d','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
         array('policy_name'=>'Strict','duration'=>'2w','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
         array('policy_name'=>'Very Strict','duration'=>'1m','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),

                    
          ));
        
    }
}
