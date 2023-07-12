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
                    'policy' => 'Não é permitido fumar',
                    'policyEN' => 'No smoking allowed'
                ], [
                    'policy' => 'Não são permitidos animais de estimação',
                    'policyEN' => 'No pets allowed'
                ], [
                    'policy' => 'Check-in a partir das 15:00',
                    'policyEN' => 'Check-in from 15:00'
                ], [
                    'policy' => 'Check-out até às 12:00',
                    'policyEN' => 'Check-out until 12:00'
                ]]
            ),
            'accesses' => json_encode(
                [
                    [
                        'access' => 'Acesso a pessoas com mobilidade reduzida',
                        'accessEN' => 'Access for people with reduced mobility'
                    ],
                    [
                        'access' => 'Elevador, Estacionamento',
                        'accessEN' => 'Elevator, Parking'
                    ],
                    [
                        'access' => 'WC adaptado',
                        'accessEN' => 'Adapted restroom'
                    ],
                    [
                        'access' => ' Entrada de rua particular',
                        'accessEN' => 'Private street entrance'
                    ]
                ]
            ),
            'commodities' => json_encode(
                [
                    [
                        'commodity' => 'Ar condicionado',
                        'commodityEN' => 'Air conditioning'
                    ],
                    [
                        'commodity' => 'TV, Telefone',
                        'commodityEN' => 'TV, Telephone'
                    ], [
                        'commodity' => 'Telefone',
                        'commodityEN' => 'Telephone'
                    ], [
                        'commodity' => 'Internet',
                        'commodityEN' => 'Internet'
                    ], [
                        'commodity' => 'Secador de cabelo',
                        'commodityEN' => 'Hairdryer'
                    ], [
                        'commodity' => 'Cofre',
                        'commodityEN' => 'Safe'
                    ], [
                        'commodity' => 'Mini-bar',
                        'commodityEN' => 'Mini-bar'
                    ], [
                        'commodity' => 'Serviço de quartos',
                        'commodityEN' => 'Room service'
                    ], [
                        'commodity' => 'Serviço de limpeza',
                        'commodityEN' => 'Cleaning service'
                    ]
                ]
            ),
            'created_at' => '2023-01-01 00:00',
            'updated_at' => $now,
        ];

        DB::table('hotels')->insert($hotel);
    }
}
