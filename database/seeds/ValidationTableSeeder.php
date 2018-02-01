<?php

use Illuminate\Database\Seeder;

class ValidationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('validations')->truncate();
        DB::table('validations')->insert([

            ['validation_text' => 'Required',
              'validation' => 'required'
            ],
            ['validation_text' => 'Date',
                'validation' => 'date'
            ],
            ['validation_text' => 'Numeric',
                'validation' => 'numeric'
            ],
            ['validation_text' => 'Alpha Numeric',
                'validation' => 'alpha_space_numeric'
            ],
            ['validation_text' => 'Alpha',
                'validation' => 'alpha_spaces'
            ],
            ['validation_text' => 'Email',
                'validation' => 'email'
            ],
            ['validation_text' => 'Url',
                'validation' => 'url'
            ],
            ['validation_text' => 'File Count',
                'validation' => 'upload_count'
            ]

        ]);
    }
}
