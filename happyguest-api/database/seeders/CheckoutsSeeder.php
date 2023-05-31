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
                'user_id' => 4,
                'code_id' => 1,
                'validated' => true,
                'created_at' => $now->add(new \DateInterval('P3D'))->format('Y-m-d'),
            ],
            [
                'user_id' => 5,
                'code_id' => 2,
                'validated' => false,
                'created_at' => $now,
            ],

        ];

        DB::table('checkouts')->insert($checkouts);
    }
}
