<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsSeeder extends Seeder
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
            'proximity' => json_encode(
                [
                    [
                        'name' => 'Leiria Shopping',
                        'description' => 'O maior centro comercial da região',
                        'description_en' => 'The largest shopping center in the region',
                        'distance' => '650m',
                        'link' => 'https://goo.gl/maps/izC4nED89TkENn3y9'
                    ],
                    [
                        'name' => 'Parque Verde',
                        'description' => 'Parque amplo para passear',
                        'description_en' => 'Large park for strolling',
                        'distance' => '1.2km',
                        'link' => 'https://goo.gl/maps/JKNGiSJ1P24MEEVM9'
                    ],
                    [
                        'name' => 'McDonald - D. Dinis',
                        'description' => 'Restaurante de fast food',
                        'description_en' => 'Fast food restaurant',
                        'distance' => '1.3km',
                        'link' => 'https://goo.gl/maps/xGSSHFtuX1cMWfte7'
                    ],
                    [
                        'name' => 'Pingo Doce - D. Dinis',
                        'description' => 'Supermercado Grande Superfície',
                        'description_en' => 'Large Supermarket',
                        'distance' => '1.3km',
                        'link' => 'https://goo.gl/maps/BoQTdxGd2TdSy3CQ9'
                    ],
                    [
                        'name' => 'Jardim Luís de Camões',
                        'description' => 'Jardim com parque infantil',
                        'description_en' => 'Garden with playground',
                        'distance' => '2.5km',
                        'link' => 'https://goo.gl/maps/QeeK1t4PeQpVoRAq6'
                    ],
                    [
                        'name' => 'Cinema City Leiria',
                        'description' => 'Cinema com várias salas e restaurantes',
                        'description_en' => 'Cinema with several rooms and restaurants',
                        'distance' => '2.8km',
                        'link' => 'https://goo.gl/maps/pJ5ehrBGcqCqHWfz6'
                    ],
                    [
                        'name' => 'Castelo de Leiria',
                        'description' => 'Castelo medieval com vista para a cidade',
                        'description_en' => 'Medieval castle overlooking the city',
                        'distance' => '2.8km',
                        'link' => 'https://goo.gl/maps/hqhvLmGtKWMvWveWA'
                    ],
                    [
                        'name' => 'Estádio Dr. Magalhães Pessoa',
                        'description' => 'Estádio de futebol do União de Leiria',
                        'description_en' => 'Football stadium of União de Leiria',
                        'distance' => '3km',
                        'link' => 'https://goo.gl/maps/5csPcTgnJfeJxyaM6'
                    ],
                    [
                        'name' => 'Hospital Santo André',
                        'description' => 'Hospital Público de Leiria',
                        'description_en' => 'Public Hospital of Leiria',
                        'distance' => '4.5km',
                        'link' => 'https://goo.gl/maps/7esaqYUi1uthvyfY9'
                    ]
                ]
            ),
            'activities' => json_encode(
                [
                    ['name' => 'Rota Leiria Histórica', 'description' => 'Percurso pedestre por zona históricas de leiria', 'description_en' => 'Pedestrian route through historical areas of leiria', 'distance' => '4km', 'link' => 'https://www.visiteleiria.pt/percursos-pedestres/rota-leiria-historica/'],
                    ['name' => 'Visita Castelo Leiria', 'description' => 'Visita ao Castelo de Leiria', 'description_en' => 'Visit to Leiria Castle', 'distance' => '4km', 'link' => 'https://www.visiteleiria.pt/en/pontos-de-interesse/heritage/leiria-castle/'],
                    ['name' => 'Escape Room Leiria', 'description' => 'Jogo interativo com puzzels e mistério', 'description_en' => 'Interactive game with puzzles and mystery', 'distance' => '4km', 'link' => 'https://www.escaperoomleiria.pt/'],
                    ['name' => 'Laserquest', 'description' => 'Jogo de laser tag', 'description_en' => 'Laser tag game', 'distance' => '4km', 'link' => 'https://www.laserquest.pt/'],
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
