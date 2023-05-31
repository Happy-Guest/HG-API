<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $complaints = [
            [
                'user_id' => 5,
                'title' => 'Serviço Insatisfatório',
                'date' => '2023-01-24 10:00',
                'status' => 'C',
                'comment' => 'Não me senti bem atendida.',
                'local' => 'Recepção',
                'created_at' => '2023-01-24 12:23',
                'updated_at' => $now,
            ],
            [
                'user_id' => 5,
                'title' => 'Atendimento Rude',
                'date' => '2023-01-26 13:25',
                'status' => 'R',
                'comment' => 'Serviço muito mal feito e demorado.',
                'local' => 'Restaurante',
                'created_at' => '2023-01-26 14:00',
                'updated_at' => $now,
            ],
            [
                'user_id' => 9,
                'title' => 'Pedido Errado',
                'date' => '2023-04-18 22:12',
                'status' => 'R',
                'comment' => 'Não recebi o que pedi no quarto.',
                'local' => 'Quarto',
                'created_at' => '2023-04-18 22:30',
                'updated_at' => $now,
            ],
            [
                'user_id' => null,
                'title' => 'Muito Barulho',
                'date' => $now->sub(new \DateInterval('P3D'))->format('Y-m-d H:i:s'),
                'status' => 'S',
                'comment' => 'Não Consegui Dormir Por Causa Do Barulho.',
                'local' => 'Quarto',
                'created_at' => $now->sub(new \DateInterval('P3D'))->format('Y-m-d H:i:s'),
                'updated_at' => $now,
            ]
        ];

        DB::table('complaints')->insert($complaints);
    }
}
