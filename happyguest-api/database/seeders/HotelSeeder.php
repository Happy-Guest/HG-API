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
            'description' => 'Bem-vindo ao Hotel Leiria: um refúgio paradisíaco que mescla luxo, conforto e beleza em harmonia perfeita. Aqui, suas experiências são transformadas em memórias inesquecíveis.',
            'phone' => '244801801',
            'email' => 'hotelLeiria@happyguest.pt',
            'address' => 'Rua do Hotel, 1',
            'website' => 'www.hotelLeiria.pt',
            'capacity' => 100,
            'policies' => 'Não é permitido fumar',
            'access' => 'Acesso a pessoas com mobilidade reduzida',
            'created_at' => '2023-01-01 00:00',
            'updated_at' => $now,
        ];

        DB::table('hotel')->insert($hotel);
    }
}
