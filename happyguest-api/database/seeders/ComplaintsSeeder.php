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
                'user_id' => 4,
                'title' => 'Serviço Insatisfatório',
                'date' => '2021/01/01 10:00',
                'status' => 'P',
                'comment' => 'Não Foi Atendido Adequadamente',
                'local' => 'Recepção',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 4,
                'title' => 'Atendimento Rude',
                'date' => '2023/01/21 16:25',
                'status' => 'R',
                'comment' => 'Fui Maltratado Por Um Funcionário',
                'local' => 'Restaurante',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 5,
                'title' => 'Promessa Não Cumprida',
                'date' => '2023/05/11 22:12',
                'status' => 'C',
                'comment' => 'Não Recebi O Que Foi Prometido.',
                'local' => 'Quarto',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('complaints')->insert($complaints);
    }
}
