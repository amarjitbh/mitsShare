<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         
        $this->call(InputFieldTypeTableSeeder::class);
        $this->call(ValidationTableSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(SellerSeeder::class);
         $this->call(CancellationPolicy::class);
         $this->call(TemplateLogEmailSeed::class);
    }
}
