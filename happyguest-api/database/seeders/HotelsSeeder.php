<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelsSeeder extends Seeder
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
            'policies' => 'Não é permitido fumar, Não são permitidos animais de estimação, Check-in a partir das 15:00, Check-out até às 12:00',
            'access' => 'Acesso a pessoas com mobilidade reduzida, Elevador, Estacionamento, WC adaptado, Entrada de rua particular',
            'comodities' => 'Ar condicionado, TV, Telefone, Internet, Secador de cabelo, Cofre, Mini-bar, Serviço de quartos, Serviço de limpeza, Serviço de bagagem, Bar, Restaurante, Ginásio, Piscina, SPA, Sauna, Jacuzzi, Sala de eventos',
            'created_at' => '2023-01-01 00:00',
            'updated_at' => $now,
        ];

        DB::table('hotels')->insert($hotel);
    }
}
