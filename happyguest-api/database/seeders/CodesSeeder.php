<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $now2 = new DateTime();
        $codes = [
            [
                'code' => 'A1352',
                'rooms' => json_encode(['10']),
                'entry_date' => '2023-01-23',
                'exit_date' => '2023-01-26',
                'used' => true,
                'created_at' => '2023-01-23 12:03:23',
                'updated_at' => $now,
            ],
            [
                'code' => 'E3D41',
                'rooms' => json_encode(['7']),
                'entry_date' => '2023-02-13',
                'exit_date' => '2023-02-15',
                'used' => false,
                'created_at' => '2023-02-12 09:23:12',
                'updated_at' => $now,
            ],
            [
                'code' => 'H12A4',
                'rooms' => json_encode(['22', '23']),
                'entry_date' => '2023-03-27',
                'exit_date' => '2023-04-03',
                'used' => true,
                'created_at' => '2023-03-27 15:34:07',
                'updated_at' => $now,
            ],
            [
                'code' => 'J42F7',
                'rooms' => json_encode(['4']),
                'entry_date' => '2023-04-15',
                'exit_date' => '2023-04-21',
                'used' => true,
                'created_at' => '2023-04-14 21:45:12',
                'updated_at' => $now,
            ],
            [
                'code' => 'B13B1',
                'rooms' => json_encode(['2', '13']),
                'entry_date' => $now2->sub(new \DateInterval('P4D'))->format('Y-m-d'),
                'exit_date' => $now2->add(new \DateInterval('P4D'))->format('Y-m-d'),
                'used' => true,
                'created_at' => $now2->sub(new \DateInterval('P4D'))->format('Y-m-d H:i:s'),
                'updated_at' => $now,
            ],
            [
                'code' => 'C1CH2',
                'rooms' => json_encode(['4']),
                'entry_date' => $now2->add(new \DateInterval('P5D'))->format('Y-m-d'),
                'exit_date' => $now2->add(new \DateInterval('P7D'))->format('Y-m-d'),
                'used' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('codes')->insert($codes);
    }
}
