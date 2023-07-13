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
            'descriptionEN' => 'Welcome to the Leiria Hotel, a paradisiacal retreat that blends luxury, comfort, and beauty in perfect harmony. Here, your experiences are transformed into unforgettable memories.',
            'phone' => '244801801',
            'email' => 'hotelLeiria@happyguest.pt',
            'address' => 'Rua do Hotel 1, 2400-000 Leiria',
            'website' => 'www.hotelLeiria.pt',
            'capacity' => 115,
            'policies' => json_encode(
                [[
                    'name' => 'Não é permitido fumar',
                    'nameEN' => 'No smoking allowed'
                ], [
                    'name' => 'Não são permitidos animais de estimação',
                    'nameEN' => 'No pets allowed'
                ], [
                    'name' => 'Check-in a partir das 15:00',
                    'nameEN' => 'Check-in from 15:00'
                ], [
                    'name' => 'Check-out até às 12:00',
                    'nameEN' => 'Check-out until 12:00'
                ]]
            ),
            'accesses' => json_encode(
                [
                    [
                        'name' => 'Acesso a pessoas com mobilidade reduzida',
                        'nameEN' => 'Access for people with reduced mobility'
                    ],
                    [
                        'name' => 'Elevador, Estacionamento',
                        'nameEN' => 'Elevator, Parking'
                    ],
                    [
                        'name' => 'WC adaptado',
                        'nameEN' => 'Adapted restroom'
                    ],
                    [
                        'name' => ' Entrada de rua particular',
                        'nameEN' => 'Private street entrance'
                    ]
                ]
            ),
            'commodities' => json_encode(
                [
                    [
                        'name' => 'Ar condicionado',
                        'nameEN' => 'Air conditioning'
                    ],
                    [
                        'name' => 'TV, Telefone',
                        'nameEN' => 'TV, Telephone'
                    ], [
                        'name' => 'Telefone',
                        'nameEN' => 'Telephone'
                    ], [
                        'name' => 'Internet',
                        'nameEN' => 'Internet'
                    ], [
                        'name' => 'Secador de cabelo',
                        'nameEN' => 'Hairdryer'
                    ], [
                        'name' => 'Cofre',
                        'nameEN' => 'Safe'
                    ], [
                        'name' => 'Mini-bar',
                        'nameEN' => 'Mini-bar'
                    ], [
                        'name' => 'Serviço de quartos',
                        'nameEN' => 'Room service'
                    ], [
                        'name' => 'Serviço de limpeza',
                        'nameEN' => 'Cleaning service'
                    ]
                ]
            ),
            'created_at' => '2023-01-01 00:00',
            'updated_at' => $now,
        ];

        DB::table('hotels')->insert($hotel);
    }
}
