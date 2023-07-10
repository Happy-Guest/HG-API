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
                    ['Leiria Shopping', 'O maior centro comercial da região', 'The largest shopping center in the region', '650m', 'https://goo.gl/maps/izC4nED89TkENn3y9'],
                    ['Hôma Leiria', 'Loja de decoração', 'Decoration store', '1.1km', 'https://goo.gl/maps/43mzr7sFgYRfEsob9'],
                    ['Parque Verde', 'Parque amplo para passear', 'Large park for strolling', '1.2km', 'https://goo.gl/maps/JKNGiSJ1P24MEEVM9'],
                    ['McDonald - D. Dinis', 'Restaurante de fast food', 'Fast food restaurant', '1.3km', 'https://goo.gl/maps/xGSSHFtuX1cMWfte7'],
                    ['Pingo Doce - D. Dinis', 'Supermercado', 'Supermarket', '1.3km', 'https://goo.gl/maps/BoQTdxGd2TdSy3CQ9'],
                    ['Jardim Luís de Camões', 'Jardim', 'Garden', '2.5km', 'https://goo.gl/maps/QeeK1t4PeQpVoRAq6'],
                    ['Cinema City Leiria', 'Cinema', 'Cinema', '2.8km', 'https://goo.gl/maps/pJ5ehrBGcqCqHWfz6'],
                    ['Castelo de Leiria', 'Castelo medieval', 'Medieval castle', '2.8km', 'https://goo.gl/maps/hqhvLmGtKWMvWveWA'],
                    ['Estádio Dr. Magalhães Pessoa', 'Estádio de futebol', 'Football stadium', '3km', 'https://goo.gl/maps/5csPcTgnJfeJxyaM6'],
                    ['Hospital Santo André - Hospital Distrital de Leiria', 'Hospital', 'Hospital', '4.5km', 'https://goo.gl/maps/7esaqYUi1uthvyfY9']
                ]
            ), //name, description, descriptionEN, distance, time on foot
            'activities' => json_encode(
                [
                    ['Rota Leiria Histórica', 'Percurso pedestre por zona históricas de leiria - 4km', 'Pedestrian route through historical areas of leiria - 4km', 'https://www.visiteleiria.pt/percursos-pedestres/rota-leiria-historica/'],
                    ['Visita castelo Leiria', 'Visita ao castelo de Leiria', 'Visit to Leiria castle', 'https://www.visiteleiria.pt/en/pontos-de-interesse/heritage/leiria-castle/'],
                    ['Escape Room Leiria', 'Jogo interativo com puzzels e mistério', 'Interactive game with puzzles and mystery', 'https://www.escaperoomleiria.pt/'],
                    ['Laserquest', 'Jogo de laser tag', 'Laser tag game', 'https://www.laserquest.pt/'],
                ]
            ),
            'websites' => json_encode(
                [['Visite Leiria', 'https://www.visiteleiria.pt/'], ['Agenda Cultural', 'https://www.viralagenda.com/pt/leiria']]
            ),
            'created_at' => '2023-01-01 00:00',
            'updated_at' => $now,
        ];

        DB::table('regions')->insert($region);
    }
}
