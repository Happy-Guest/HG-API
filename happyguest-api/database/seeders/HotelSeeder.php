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
            'descriptionEN' => 'Welcome to the Leiria Hotel, a paradisiacal retreat that blends luxury, comfort, and beauty in perfect harmony. Here, your experiences are transformed into unforgettable memories.',
            'phone' => '244801801',
            'email' => 'hotelLeiria@happyguest.pt',
            'address' => 'Rua do Hotel 1, 2400-000 Leiria',
            'website' => 'www.hotelLeiria.pt',
            'capacity' => 115,
            'policies' => 'Não é permitido fumar, Não são permitidos animais de estimação, Check-in a partir das 15:00, Check-out até às 12:00',
            'policiesEN' => 'No smoking allowed, No pets allowed, Check-in from 15:00, Check-out until 12:00',
            'access' => 'Acesso a pessoas com mobilidade reduzida, Elevador, Estacionamento, WC adaptado, Entrada de rua particular',
            'accessEN' => 'Accessible to people with reduced mobility, Elevator, Parking, Adapted restroom, Private street entrance',
            'comodities' => 'Ar condicionado, TV, Telefone, Internet, Secador de cabelo, Cofre, Mini-bar, Serviço de quartos, Serviço de limpeza, Serviço de bagagem, Bar, Restaurante, Ginásio, Piscina, SPA, Sauna, Jacuzzi, Sala de eventos',
            'comoditiesEN' => 'Air conditioning, TV, Telephone, Internet, Hairdryer, Safe, Mini-bar, Room service, Cleaning service, Luggage service, Bar, Restaurant, Gym, Pool, SPA, Sauna, Jacuzzi, Event room',
            'created_at' => '2023-01-01 00:00',
            'updated_at' => $now,
        ];

        DB::table('hotel')->insert($hotel);
    }
}
