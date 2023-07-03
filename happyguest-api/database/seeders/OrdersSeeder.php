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
        $now2 = new DateTime();
        $orders = [
            [
                'user_id' => 5,
                'room' => '10',
                'time' => '2023-01-24 10:00',
                'status' => 'DL',
                'service_id' => 1, //Pedido limpeza
                'price' => null,
                'comment' => 'Limpeza de quarto completa por favor!',
                'created_at' => '2023-01-23 22:30',
                'updated_at' => $now,
            ],
            [
                'user_id' => 7,
                'room' => '22',
                'time' => '2023-03-27 21:00',
                'status' => 'C',
                'service_id' => 3, //Pedido alimentação jantar
                'price' => 30.5,
                'comment' => null,
                'created_at' => '2023-03-27 21:00',
                'updated_at' => $now,
            ],
            [
                'user_id' => 7,
                'room' => '22',
                'time' => '2023-03-27 21:05',
                'status' => 'DL',
                'service_id' => 3, //Pedido alimentação jantar
                'price' => 31,
                'comment' => null,
                'created_at' => '2023-03-27 21:05',
                'updated_at' => $now,
            ],
            [
                'user_id' => 9,
                'room' => '4',
                'time' => '2023-04-18 9:30',
                'status' => 'DL',
                'service_id' => 2, //Pedido objetos
                'price' => null,
                'comment' => null,
                'created_at' => '2023-04-18 9:30',
                'updated_at' => $now,
            ],
            [
                'user_id' => 9,
                'room' => '4',
                'time' => '2023-04-18 10:10',
                'status' => 'DL',
                'service_id' => 2, //Pedido alimentação pequeno almoço
                'price' => 8,
                'comment' => 'Com pouco sal.',
                'created_at' => '2023-04-18 10:10',
                'updated_at' => $now,
            ],
            [
                'user_id' => 9,
                'room' => '4',
                'time' => '2023-04-18 18:00',
                'status' => 'R',
                'service_id' => 2, //Pedido alimentação jantar
                'price' => 30,
                'comment' => null,
                'created_at' => '2023-04-18 18:00',
                'updated_at' => $now,
            ],
            [
                'user_id' => 11,
                'room' => '13',
                'time' => $now2->add(new \DateInterval('P1D'))->format('Y-m-d') . ' 10:00',
                'status' => 'P',
                'service_id' => 1, //Pedido limpeza
                'price' => null,
                'comment' => null,
                'created_at' => $now2->sub(new \DateInterval('P1D'))->format('Y-m-d H:i'),
                'updated_at' => $now,
            ]
        ];

        DB::table('orders')->insert($orders);
    }
}
