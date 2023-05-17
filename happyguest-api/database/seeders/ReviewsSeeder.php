<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $reviews = [
            [
                'user_id' => 4,
                'stars' => 5,
                'comment' => 'Muito bom',
                'autorize' => false,
                'shared' => false,
                'created_at' => $now,
            ],
            [
                'user_id' => null,
                'stars' => 2,
                'comment' => 'Muito mau',
                'autorize' => false,
                'shared' => false,
                'created_at' => $now,
            ],
            [
                'user_id' => 5,
                'stars' => 4,
                'comment' => 'Bom',
                'autorize' => true,
                'shared' => true,
                'created_at' => $now,
            ],
        ];

        DB::table('reviews')->insert($reviews);
    }
}
