<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckoutsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $checkouts = [
            [
                'user_id' => 7,
                'code_id' => 3,
                'validated' => true,
                'date' => '2023-04-03 16:25'
            ],
            [
                'user_id' => 9,
                'code_id' => 4,
                'validated' => true,
                'date' => '2023-04-20 21:12',
            ],
            [
                'user_id' => 11,
                'code_id' => 5,
                'validated' => false,
                'date' => $now,
            ]

        ];

        DB::table('checkouts')->insert($checkouts);
    }
}
