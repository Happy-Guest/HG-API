<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class regionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $region = [
            'description' => 'Leiria está estrategicamente localizada, a sensivelmente meio caminho de Lisboa e do Porto. Integrada na região Centro, a “cidade do Lis” é a porta de entrada para um território vasto e rico, que inclui praia, natureza, património e cultura',
            'descriptionEN' => 'Leiria is strategically located, roughly halfway between Lisbon and Porto. Integrated in the Central region, the “city of Lis” is the gateway to a vast and rich territory, which includes beach, nature, heritage and culture',
            'proximities' => json_encode(
                [
                    [
                        'name' => 'Leiria Shopping',
                        'description' => 'O maior centro comercial da região',
                        'description_en' => 'The largest shopping center in the region',
                        'distance' => '650m',
                        'map_link' => 'https://goo.gl/maps/izC4nED89TkENn3y9'
                    ],
                    [
                        'name' => 'Hôma Leiria',
                        'description' => 'Loja de decoração',
                        'description_en' => 'Decoration store',
                        'distance' => '1.1km',
                        'map_link' => 'https://goo.gl/maps/43mzr7sFgYRfEsob9'
                    ],
                    [
                        'name' => 'Parque Verde',
                        'description' => 'Parque amplo para passear',
                        'description_en' => 'Large park for strolling',
                        'distance' => '1.2km',
                        'map_link' => 'https://goo.gl/maps/JKNGiSJ1P24MEEVM9'
                    ],
                    [
                        'name' => 'McDonald - D. Dinis',
                        'description' => 'Restaurante de fast food',
                        'description_en' => 'Fast food restaurant',
                        'distance' => '1.3km',
                        'map_link' => 'https://goo.gl/maps/xGSSHFtuX1cMWfte7'
                    ],
                    [
                        'name' => 'Pingo Doce - D. Dinis',
                        'description' => 'Supermercado',
                        'description_en' => 'Supermarket',
                        'distance' => '1.3km',
                        'map_link' => 'https://goo.gl/maps/BoQTdxGd2TdSy3CQ9'
                    ],
                    [
                        'name' => 'Jardim Luís de Camões',
                        'description' => 'Jardim',
                        'description_en' => 'Garden',
                        'distance' => '2.5km',
                        'map_link' => 'https://goo.gl/maps/QeeK1t4PeQpVoRAq6'
                    ],
                    [
                        'name' => 'Cinema City Leiria',
                        'description' => 'Cinema',
                        'description_en' => 'Cinema',
                        'distance' => '2.8km',
                        'map_link' => 'https://goo.gl/maps/pJ5ehrBGcqCqHWfz6'
                    ],
                    [
                        'name' => 'Castelo de Leiria',
                        'description' => 'Castelo medieval',
                        'description_en' => 'Medieval castle',
                        'distance' => '2.8km',
                        'map_link' => 'https://goo.gl/maps/hqhvLmGtKWMvWveWA'
                    ],
                    [
                        'name' => 'Estádio Dr. Magalhães Pessoa',
                        'description' => 'Estádio de futebol',
                        'description_en' => 'Football stadium',
                        'distance' => '3km',
                        'map_link' => 'https://goo.gl/maps/5csPcTgnJfeJxyaM6'
                    ],
                    [
                        'name' => 'Hospital Santo André - Hospital Distrital de Leiria',
                        'description' => 'Hospital',
                        'description_en' => 'Hospital',
                        'distance' => '4.5km',
                        'map_link' => 'https://goo.gl/maps/7esaqYUi1uthvyfY9'
                    ]
                ]
            ), //name, description, descriptionEN, distance, time on foot
            'activities' => json_encode(
                [
                    ['name' => 'Rota Leiria Histórica', 'description' => 'Percurso pedestre por zona históricas de leiria - 4km', 'description_en' => 'Pedestrian route through historical areas of leiria - 4km', 'link' => 'https://www.visiteleiria.pt/percursos-pedestres/rota-leiria-historica/'],
                    ['name' => 'Visita castelo Leiria', 'description' => 'Visita ao castelo de Leiria', 'description_en' => 'Visit to Leiria castle', 'link' => 'https://www.visiteleiria.pt/en/pontos-de-interesse/heritage/leiria-castle/'],
                    ['name' => 'Escape Room Leiria', 'description' => 'Jogo interativo com puzzels e mistério', 'description_en' => 'Interactive game with puzzles and mystery', 'link' => 'https://www.escaperoomleiria.pt/'],
                    ['name' => 'Laserquest', 'description' => 'Jogo de laser tag', 'description_en' => 'Laser tag game', 'link' => 'https://www.laserquest.pt/'],
                ]
            ),
            'websites' => json_encode(
                [['name' => 'Visite Leiria', 'link' => 'https://www.visiteleiria.pt/'], ['name' => 'Agenda Cultural', 'link' => 'https://www.viralagenda.com/pt/leiria']]
            ),
            'created_at' => '2023-01-01 00:00',
            'updated_at' => $now,
        ];

        DB::table('regions')->insert($region);
    }
}