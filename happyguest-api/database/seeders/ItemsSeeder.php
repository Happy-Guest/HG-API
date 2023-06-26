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
            // Objects
            [
                'name' => 'Almofada',
                'price' => null,
                'type' => 'O',
                'category' => 'room',
                'stock' => 20,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Cobertor',
                'price' => null,
                'type' => 'O',
                'category' => 'room',
                'stock' => 10,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Toalha',
                'price' => null,
                'type' => 'O',
                'category' => 'bathroom',
                'stock' => 30,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Papel Higiénico',
                'price' => null,
                'type' => 'O',
                'category' => 'bathroom',
                'stock' => 30,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Gel de Duche',
                'price' => null,
                'type' => 'O',
                'category' => 'bathroom',
                'stock' => 50,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Champô',
                'price' => null,
                'type' => 'O',
                'category' => 'bathroom',
                'stock' => 50,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Adapatador de Tomada',
                'price' => null,
                'type' => 'O',
                'category' => 'other',
                'stock' => 10,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Jornal do Dia',
                'price' => null,
                'type' => 'O',
                'category' => 'other',
                'stock' => 20,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            // Foods
            [
                'name' => 'Água (33cl)',
                'price' => 1,
                'type' => 'F',
                'category' => 'drink',
                'stock' => 15,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Coca-Cola (33cl)',
                'price' => 2,
                'type' => 'F',
                'category' => 'drink',
                'stock' => 15,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Garrafa de Champanhe',
                'price' => 15,
                'type' => 'F',
                'category' => 'drink',
                'stock' => 10,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Café',
                'price' => 0.85,
                'type' => 'F',
                'category' => 'drink',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Tosta Mista',
                'price' => 3.5,
                'type' => 'F',
                'category' => 'snack',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Sandes Mista',
                'price' => 3,
                'type' => 'F',
                'category' => 'snack',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Pequeno-Almoço Continental',
                'price' => 6,
                'type' => 'F',
                'category' => 'breakfast',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Ovos Mexidos com Bacon',
                'price' => 5.5,
                'type' => 'F',
                'category' => 'breakfast',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Panquecas com Toppings',
                'price' => 5,
                'type' => 'F',
                'category' => 'breakfast',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Tigela de Aveia com Frutas',
                'price' => 3.5,
                'type' => 'F',
                'category' => 'breakfast',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Sumo de Laranja Natural',
                'price' => 2.5,
                'type' => 'F',
                'category' => 'breakfast',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Salada Caesar com Frango Grelhado',
                'price' => 10,
                'type' => 'F',
                'category' => 'lunch',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Massa Pesto com Tomates Secos',
                'price' => 11.5,
                'type' => 'F',
                'category' => 'lunch',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Hambúrguer Vegetariano',
                'price' => 9,
                'type' => 'F',
                'category' => 'lunch',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Wrap de Frango com Guacamole',
                'price' => 8.5,
                'type' => 'F',
                'category' => 'lunch',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Bife com Molho de Cogumelos',
                'price' => 15,
                'type' => 'F',
                'category' => 'dinner',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Salmão Grelhado com Molho de Limão',
                'price' => 15,
                'type' => 'F',
                'category' => 'dinner',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Risoto de Cogumelos Porcini',
                'price' => 13,
                'type' => 'F',
                'category' => 'dinner',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Frango Assado com Batatas',
                'price' => 12.5,
                'type' => 'F',
                'category' => 'dinner',
                'stock' => null,
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
        ];

        DB::table('items')->insert($items);
    }
}
