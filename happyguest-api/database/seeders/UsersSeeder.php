<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $lastMonth = new DateTime();
        $lastMonth->modify('-1 month');
        $fourMonthsAgo = new DateTime();
        $fourMonthsAgo->modify('-4 month');
        $eightMonthsAgo = new DateTime();
        $eightMonthsAgo->modify('-8 month');

        $users = [
            [
                'name' => 'Diogo Mendes',
                'email' => 'diiogom21@happyguest.pt',
                'phone' => '914310511',
                'password' => bcrypt('123456789'),
                'role' => 'A',
                'blocked' => false,
                'photo_url' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tomás Neves',
                'email' => 'tomasn@happyguest.pt',
                'phone' => '966938453',
                'password' => bcrypt('123456789'),
                'role' => 'A',
                'blocked' => false,
                'photo_url' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'João Silva',
                'email' => 'joao@email.pt',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'role' => 'M',
                'blocked' => false,
                'photo_url' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Daniel Santos',
                'email' => 'dani@email.pt',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'role' => 'C',
                'blocked' => false,
                'photo_url' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria@email.pt',
                'phone' => '924738372',
                'password' => bcrypt('123456789'),
                'role' => 'C',
                'blocked' => false,
                'photo_url' => null,
                'created_at' => $lastMonth,
                'updated_at' => $now,
            ],
            [
                'name' => 'José Costa',
                'email' => 'josec@hotmail.com',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'role' => 'C',
                'blocked' => false,
                'photo_url' => null,
                'created_at' => $fourMonthsAgo,
                'updated_at' => $now,
            ],
            [
                'name' => 'Ana Rodrigues',
                'email' => 'anar@mail.com',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'role' => 'C',
                'blocked' => true,
                'photo_url' => null,
                'created_at' => $eightMonthsAgo,
                'updated_at' => $now,
            ],
            [
                'name' => 'Rui Pereira',
                'email' => 'rpereira@mail.pt',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'role' => 'C',
                'blocked' => false,
                'photo_url' => null,
                'created_at' => $eightMonthsAgo,
                'updated_at' => $now,
            ],
        ];

        DB::table('users')->insert($users);
    }
}
