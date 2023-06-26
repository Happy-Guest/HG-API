<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $services = [
            [
                'name' => 'Limpeza de quarto',
                'email' => 'limpeza@happyguest.pt',
                'phone' => '912345678',
                'type' => 'C',
                'schedule' => '9-14-15-21',
                'occupation' => null,
                'location' => 'Quarto',
                'limit' => '2',
                'description' => 'Serviço de limpeza de quarto no hotel, disponível gratuitamente. Pode especificar uma hora para ser feita a limpeza do seu quarto.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Pedido de objetos',
                'email' => 'objetos@happyguest.pt',
                'phone' => '912345679',
                'type' => 'O',
                'schedule' => '8-23',
                'occupation' => null,
                'location' => 'Quarto',
                'limit' => '4',
                'description' => 'Serviço de pedido de objetos no quarto, disponível gratuitamente. Pode especificar o objeto de entre os disponíveis, que nós entregamos o mais rapidamente possivel no seu quarto.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Pedido de alimentos',
                'email' => 'alimentos@happyguest.pt',
                'phone' => '912345677',
                'type' => 'F',
                'schedule' => '7-23',
                'occupation' => null,
                'location' => 'Quarto',
                'limit' => '3',
                'description' => 'Serviço de pedido de comida no quarto, disponível gratuitamente. Pode especificar o alimento que pretende receber no quarto de entre os disponivéis e a sua quantidade.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Reservar mesa',
                'email' => 'restaurante@happyguest.pt',
                'phone' => '912345676',
                'type' => 'R',
                'schedule' => '11-15-19-23',
                'occupation' => 200,
                'location' => 'Restaurante',
                'limit' => '1',
                'description' => 'Serviço de reserva de mesas no nosso restaurante. Insira o nª de pessoas e escolha um horário disponível.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],

        ];

        DB::table('services')->insert($services);
    }
}
