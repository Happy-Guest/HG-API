<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $items = [
            [
                'name' => 'Almofada',
                'price' => null,
                'type' => 'O',
                'category' => 'room',
                'amount_stock' => 10,
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'name' => 'Lençol',
                'price' => null,
                'type' => 'O',
                'category' => 'room',
                'amount_stock' => 10,
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'name' => 'Toalha',
                'price' => null,
                'type' => 'O',
                'category' => 'bathroom',
                'amount_stock' => 10,
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'name' => 'Gel de Duche',
                'price' => null,
                'type' => 'F',
                'category' => 'bathroom',
                'amount_stock' => 10,
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'name' => 'Água (33cl)',
                'price' => 1.5,
                'type' => 'F',
                'category' => 'drink',
                'amount_stock' => 10,
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'name' => 'Champanhe',
                'price' => 1.5,
                'type' => 'F',
                'category' => 'drink',
                'amount_stock' => 10,
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'name' => 'Tosta Mista',
                'price' => 3.5,
                'type' => 'O',
                'category' => 'food',
                'amount_stock' => 10,
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
            [
                'name' => 'Sandes Mista',
                'price' => 3,
                'type' => 'F',
                'category' => 'food',
                'amount_stock' => 10,
                'created_at' => '2023-06-26 22:30',
                'updated_at' => $now,
            ],
        ];

        DB::table('items')->insert($items);
    }
}
