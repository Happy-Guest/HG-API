<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $reserves = [
            [
                'user_id' => 6,
                'nr_people' => 2,
                'time' => '2023-06-27 20:00',
                'status' => 'P',
                'service_id' => 4,
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'user_id' => 7,
                'nr_people' => 2,
                'time' => '2023-06-27 20:00',
                'status' => 'P',
                'service_id' => 4,
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'user_id' => 8,
                'nr_people' => 2,
                'time' => '2023-06-27 20:00',
                'status' => 'P',
                'service_id' => 4,
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
        ];

        DB::table('reserves')->insert($reserves);
    }
}
