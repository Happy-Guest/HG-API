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
                'user_id' => 7,
                'user_name' => null,
                'nr_people' => 2,
                'time' => '2023-03-28 20:00',
                'status' => 'A',
                'service_id' => 4,
                'created_at' => '2023-03-27 16:30',
                'updated_at' => $now,
            ],
            [
                'user_id' => null,
                'user_name' => 'Joana Andrade',
                'nr_people' => 2,
                'time' => '2023-04-02 13:00',
                'status' => 'A',
                'service_id' => 4,
                'created_at' => '2023-04-02 11:25',
                'updated_at' => $now,
            ],
            [
                'user_id' => 9,
                'user_name' => null,
                'nr_people' => 2,
                'time' => '2023-04-19 12:30',
                'status' => 'C',
                'service_id' => 4,
                'created_at' => '2023-04-19 11:10',
                'updated_at' => $now,
            ],
            [
                'user_id' => null,
                'user_name' => 'João Pinto',
                'nr_people' => 1,
                'time' => '2023-06-23 20:30',
                'status' => 'A',
                'service_id' => 4,
                'created_at' => '2023-06-23 16:55',
                'updated_at' => $now,
            ],
            [
                'user_id' => 11,
                'user_name' => null,
                'nr_people' => 1,
                'time' => $now->format('Y-m-d') . ' 19:30',
                'status' => 'P',
                'service_id' => 4,
                'created_at' => $now->format('Y-m-d') . ' 19:00',
                'updated_at' => $now,
            ],
        ];

        DB::table('reserves')->insert($reserves);
    }
}
