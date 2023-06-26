<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $orderItems = [
            [
                'order_id' => 2,
                'item_id' => 27,
                'quantity' => 1,
            ],
            [
                'order_id' => 2,
                'item_id' => 25,
                'quantity' => 1,
            ],
            [
                'order_id' => 2,
                'item_id' => 9,
                'quantity' => 1,
            ],
            [
                'order_id' => 2,
                'item_id' => 10,
                'quantity' => 1,
            ],
            [
                'order_id' => 3,
                'item_id' => 26,
                'quantity' => 1,
            ],
            [
                'order_id' => 3,
                'item_id' => 25,
                'quantity' => 1,
            ],
            [
                'order_id' => 3,
                'item_id' => 9,
                'quantity' => 1,
            ],
            [
                'order_id' => 3,
                'item_id' => 10,
                'quantity' => 1,
            ],
            [
                'order_id' => 4,
                'item_id' => 1,
                'quantity' => 1,
            ],
            [
                'order_id' => 4,
                'item_id' => 2,
                'quantity' => 1,
            ],
            [
                'order_id' => 5,
                'item_id' => 16,
                'quantity' => 1,
            ],
            [
                'order_id' => 5,
                'item_id' => 19,
                'quantity' => 1,
            ],
            [
                'order_id' => 6,
                'item_id' => 24,
                'quantity' => 2,
            ],
        ];

        DB::table('order_items')->insert($orderItems);
    }
}
