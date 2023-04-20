<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_codes = [
            [
                'user_id' => 1,
                'code_id' => 1,
            ],
            [
                'user_id' => 1,
                'code_id' => 2,
            ],
            [
                'user_id' => 2,
                'code_id' => 2,
            ],
        ];

        DB::table('user_codes')->insert($user_codes);
    }
}