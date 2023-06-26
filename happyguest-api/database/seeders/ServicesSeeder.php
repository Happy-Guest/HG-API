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
                'name' => 'Limpeza de Quarto',
                'email' => 'limpeza@happyguest.pt',
                'phone' => '244123456',
                'type' => 'C',
                'schedule' => '9-14-15-21',
                'occupation' => null,
                'location' => null,
                'limit' => '3',
                'description' => 'Serviço de limpeza de quarto no hotel, disponível gratuitamente. Pode especificar uma hora para ser feita a limpeza do seu quarto.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Pedido de Objetos',
                'email' => 'pedidosObjetos@happyguest.pt',
                'phone' => '244123457',
                'type' => 'O',
                'schedule' => '8-23',
                'occupation' => null,
                'location' => null,
                'limit' => '2',
                'description' => 'Serviço de pedido de objetos no quarto, disponível gratuitamente. Pode especificar o objeto de entre os disponíveis, que nós entregamos o mais rapidamente possivel no seu quarto.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Pedido de Alimentos',
                'email' => 'pedidosAlimentos@happyguest.pt',
                'phone' => '244123458',
                'type' => 'F',
                'schedule' => '7-23',
                'occupation' => null,
                'location' => null,
                'limit' => '3',
                'description' => 'Serviço de pedido de comida e bebida no quarto, entrega gratuita pagando apenas o valor dos alimentos. Pode especificar o alimento de entre os disponíveis, que nós entregamos o mais rapidamente possivel no seu quarto.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Reservar Mesa',
                'email' => 'restauracao@happyguest.pt',
                'phone' => '244123459',
                'type' => 'R',
                'schedule' => '11-15-19-23',
                'occupation' => 150,
                'location' => 'Restaurante Principal',
                'limit' => null,
                'description' => 'Serviço de reserva de mesas no nosso restaurante. Insira o nª de pessoas e escolha um horário disponível.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Spa',
                'email' => 'spa@happyguest.pt',
                'phone' => '244123450',
                'type' => 'O',
                'schedule' => '9-19',
                'occupation' => 10,
                'location' => 'Edificio 2',
                'limit' => null,
                'description' => 'Bem-vindo ao Spa Oasis! Desfrute de momentos tranquilos, sem custos adicionais. Massagens relaxantes, terapias faciais e tratamentos corporais estão disponíveis. Priorizamos o seu bem-estar e tranquilidade nesta pausa merecida.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Ginásio',
                'email' => 'ginasio@happyguest.pt',
                'phone' => '244123451',
                'type' => 'O',
                'schedule' => '9-19',
                'occupation' => 20,
                'location' => 'Edificio 2',
                'limit' => null,
                'description' => 'Bem-vindo ao Ginásio Fitness Plus! Instalações modernas e espaços amplos para atingir objetivos de saúde. Prepare-se para superar limites e adotar um estilo de vida ativo e saudável! Sem custos adicionais.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
        ];

        DB::table('services')->insert($services);
    }
}
