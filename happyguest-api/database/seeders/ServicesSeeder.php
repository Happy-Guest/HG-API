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
                'nameEN' => 'Room Cleaning',
                'email' => 'limpeza@happyguest.pt',
                'phone' => '244123456',
                'type' => 'C',
                'schedule' => '9-14-15-21',
                'occupation' => null,
                'location' => null,
                'limit' => '3',
                'description' => 'Serviço de limpeza de quarto no hotel, disponível gratuitamente. Pode especificar uma hora para ser feita a limpeza do seu quarto.',
                'descriptionEN' => 'Room cleaning service in the hotel, available for free. You can specify a time for your room to be cleaned.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Pedido de Objetos',
                'nameEN' => 'Object Request',
                'email' => 'pedidosObjetos@happyguest.pt',
                'phone' => '244123457',
                'type' => 'B',
                'schedule' => '8-23',
                'occupation' => null,
                'location' => null,
                'limit' => '2',
                'description' => 'Serviço de pedido de objetos no quarto, disponível gratuitamente. Pode especificar o objeto de entre os disponíveis, que nós entregamos o mais rapidamente possivel no seu quarto.',
                'descriptionEN' => 'Room object request service, available for free. You can specify the object from the available ones, which we deliver as quickly as possible to your room.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Pedido de Alimentos',
                'nameEN' => 'Food Request',
                'email' => 'pedidosAlimentos@happyguest.pt',
                'phone' => '244123458',
                'type' => 'F',
                'schedule' => '7-23',
                'occupation' => null,
                'location' => null,
                'limit' => '3',
                'description' => 'Serviço de pedido de comida e bebida no quarto, entrega gratuita pagando apenas o valor dos alimentos. Pode especificar o alimento de entre os disponíveis, que nós entregamos o mais rapidamente possivel no seu quarto.',
                'descriptionEN' => 'Room food and drink request service, free delivery paying only the value of the food. You can specify the food from the available ones, which we deliver as quickly as possible to your room.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Reservar Mesa',
                'nameEN' => 'Table Reservation',
                'email' => 'restauracao@happyguest.pt',
                'phone' => '244123459',
                'type' => 'R',
                'schedule' => '11-15-19-23',
                'occupation' => 150,
                'location' => 'Restaurante Principal',
                'limit' => null,
                'description' => 'Serviço de reserva de mesas no nosso restaurante. Insira o nª de pessoas e escolha um horário disponível.',
                'descriptionEN' => 'Table reservation service in our restaurant. Enter the number of people and choose an available time.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Spa',
                'nameEN' => 'Spa',
                'email' => 'spa@happyguest.pt',
                'phone' => '244123450',
                'type' => 'O',
                'schedule' => '9-19',
                'occupation' => 10,
                'location' => 'Edificio 2',
                'limit' => null,
                'description' => 'Bem-vindo ao Spa Oasis! Desfrute de momentos tranquilos, sem custos adicionais. Massagens relaxantes, terapias faciais e tratamentos corporais estão disponíveis. Priorizamos o seu bem-estar e tranquilidade nesta pausa merecida.',
                'descriptionEN' => 'Welcome to Spa Oasis! Enjoy quiet moments, at no additional cost. Relaxing massages, facial therapies and body treatments are available. We prioritize your well-being and tranquility on this well-deserved break.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
            [
                'name' => 'Ginásio',
                'nameEN' => 'Gym',
                'email' => 'ginasio@happyguest.pt',
                'phone' => '244123451',
                'type' => 'O',
                'schedule' => '9-19',
                'occupation' => 20,
                'location' => 'Edificio 2',
                'limit' => null,
                'description' => 'Bem-vindo ao Ginásio Fitness Plus! Instalações modernas e espaços amplos para atingir objetivos de saúde. Prepare-se para superar limites e adotar um estilo de vida ativo e saudável! Sem custos adicionais.',
                'descriptionEN' => 'Welcome to Fitness Plus Gym! Modern facilities and spacious spaces to achieve health goals. Get ready to overcome limits and adopt an active and healthy lifestyle! At no additional cost.',
                'created_at' => '2023-01-01 00:00',
                'updated_at' => $now,
            ],
        ];

        DB::table('services')->insert($services);
    }
}
