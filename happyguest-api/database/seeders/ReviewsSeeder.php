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
                'user_id' => null,
                'stars' => 2,
                'comment' => 'Muito mau.',
                'autorize' => false,
                'shared' => false,
                'created_at' => '2023-01-26 14:25'
            ],
            [
                'user_id' => 7,
                'stars' => 5,
                'comment' => 'Muito bom! Recomendo.',
                'autorize' => false,
                'shared' => false,
                'created_at' => '2023-04-03 21:12'
            ],
            [
                'user_id' => null,
                'stars' => 4,
                'comment' => 'Hotel com boas atividades e funcionários simpáticos.',
                'autorize' => true,
                'shared' => true,
                'created_at' => '2023-04-23 11:34'
            ],
            [
                'user_id' => 11,
                'stars' => 4,
                'comment' => 'Bom hotel com boa localização.',
                'autorize' => true,
                'shared' => false,
                'created_at' => $now,
            ],
        ];

        DB::table('reviews')->insert($reviews);
    }
}
