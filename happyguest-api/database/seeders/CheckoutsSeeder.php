<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class checkoutsSeeder extends Seeder
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
                'user_id' => 4,
                'code_id' => 1,
                'created_at' => $now,
            ],
            [
                'user_id' => 5,
                'code_id' => 2,
                'created_at' => $now,
            ],
           
        ];

        DB::table('checkouts')->insert($checkouts);
    }
}
