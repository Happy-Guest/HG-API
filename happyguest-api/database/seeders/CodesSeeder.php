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
        $codes = [
            [
                'code' => 'A135',
                'rooms' => json_encode(['1']),
                'entry_date' => '2021-01-01',
                'exit_date' => '2021-01-02',
                'used' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'B135',
                'rooms' => json_encode(['2', '3']),
                'entry_date' => $now->sub(new \DateInterval('P3D'))->format('Y-m-d'),
                'exit_date' => $now->add(new \DateInterval('P3D'))->format('Y-m-d'),
                'used' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'C135',
                'rooms' => json_encode(['4']),
                'entry_date' => $now->format('Y-m-d'),
                'exit_date' => $now->add(new \DateInterval('P1D'))->format('Y-m-d'),
                'used' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('codes')->insert($codes);
    }
}
