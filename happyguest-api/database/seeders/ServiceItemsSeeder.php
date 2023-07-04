<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $serviceItems = [
            [
                'service_id' => 2,
                'item_id' => 1,
            ],
            [
                'service_id' => 2,
                'item_id' => 2,
            ],
            [
                'service_id' => 2,
                'item_id' => 3,
            ],
            [
                'service_id' => 2,
                'item_id' => 4,
            ],
            [
                'service_id' => 2,
                'item_id' => 5,
            ],
            [
                'service_id' => 2,
                'item_id' => 6,
            ],
            [
                'service_id' => 2,
                'item_id' => 8,
            ],
            [
                'service_id' => 3,
                'item_id' => 9,
            ],
            [
                'service_id' => 3,
                'item_id' => 10,
            ],
            [
                'service_id' => 3,
                'item_id' => 11,
            ],
            [
                'service_id' => 3,
                'item_id' => 12,
            ],
            [
                'service_id' => 3,
                'item_id' => 13,
            ],
            [
                'service_id' => 3,
                'item_id' => 15,
            ],
            [
                'service_id' => 3,
                'item_id' => 16,
            ],
            [
                'service_id' => 3,
                'item_id' => 17,
            ],
            [
                'service_id' => 3,
                'item_id' => 18,
            ],
            [
                'service_id' => 3,
                'item_id' => 19,
            ],
            [
                'service_id' => 3,
                'item_id' => 20,
            ],
            [
                'service_id' => 3,
                'item_id' => 21,
            ],
            [
                'service_id' => 3,
                'item_id' => 22,
            ],
            [
                'service_id' => 3,
                'item_id' => 23,
            ],
            [
                'service_id' => 3,
                'item_id' => 24,
            ],
            [
                'service_id' => 3,
                'item_id' => 25,
            ],
            [
                'service_id' => 3,
                'item_id' => 26,
            ],
            [
                'service_id' => 3,
                'item_id' => 27,
            ]
        ];

        DB::table('service_items')->insert($serviceItems);
    }
}
