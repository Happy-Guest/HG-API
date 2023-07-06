<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $hotel = [
            'description' => 'Bem-vindo ao Hotel de Leiria, um refúgio paradisíaco que mescla luxo, conforto e beleza em harmonia perfeita. Aqui, suas experiências são transformadas em memórias inesquecíveis.',
            'phone' => '244801801',
            'email' => 'hotelLeiria@happyguest.pt',
            'address' => 'Rua do Hotel 1, 2400-000 Leiria',
            'website' => 'www.hotelLeiria.pt',
            'capacity' => 115,
            'policies' => 'Não é permitido fumar, Animais de estimação não são permitidos, Check-in a partir das 15:00, Check-out até às 12:00',
            'access' => 'Acesso a pessoas com mobilidade reduzida, Elevador, Estacionamento, Internet, Ar condicionado, Bar, Restaurante, Ginásio, Piscina, SPA, Sauna, Jacuzzi, Sala de eventos, Serviço de quartos, Serviço de limpeza, Serviço de bagagem',
            'created_at' => '2023-01-01 00:00',
            'updated_at' => $now,
        ];

        DB::table('hotel')->insert($hotel);
    }
}
