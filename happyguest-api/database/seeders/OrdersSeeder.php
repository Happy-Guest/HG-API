<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $orders = [
            [
                'user_id' => 6,
                'room' => 1,
                'time' => '2023-06-26 22:30',
                'status' => 'P',
                'service_id' => 3, //Pedido alimentação
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'user_id' => 6,
                'room' => 2,
                'time' => '2023-06-26 22:30',
                'status' => 'P',
                'service_id' => 2, //Pedido objetos
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'user_id' => 7,
                'room' => 3,
                'time' => '2023-06-26 22:30',
                'status' => 'P',
                'service_id' => 2, //Pedido objetos
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'user_id' => 7,
                'room' => 5,
                'time' => '2023-06-26 22:30',
                'status' => 'P',
                'service_id' => 2, //Pedido objetos
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'user_id' => 8,
                'room' => 6,
                'time' => '2023-06-26 22:30',
                'status' => 'P',
                'service_id' => 3, //Pedido alimentação
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ]
        ];

        DB::table('orders')->insert($orders);
    }
}
