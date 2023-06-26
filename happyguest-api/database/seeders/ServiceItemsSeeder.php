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
                'service_id' => 3,
                'item_id' => 5,
            ],
            [
                'service_id' => 3,
                'item_id' => 6,
            ],
            [
                'service_id' => 3,
                'item_id' => 7,
            ],
            [
                'service_id' => 3,
                'item_id' => 8,
            ]
        ];

        DB::table('service_items')->insert($serviceItems);
    }
}
