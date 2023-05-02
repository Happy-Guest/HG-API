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
        $users = [
            [
                'name' => 'Diogo Mendes',
                'email' => 'diiogom21@happyguest.pt',
                'phone' => '914310511',
                'password' => bcrypt('123456789'),
                'role' => 'A',
                'photo_url' => 'https://api.dicebear.com/6.x/avataaars/svg?seed=Diogo',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tomás Neves',
                'email' => 'tomasn@happyguest.pt',
                'phone' => '966938453',
                'password' => bcrypt('123456789'),
                'role' => 'M',
                'photo_url' => 'https://api.dicebear.com/6.x/avataaars/svg?seed=Tomas',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'João Silva',
                'email' => 'joao@email.pt',
                'phone' => '966938453',
                'password' => bcrypt('123456789'),
                'role' => 'C',
                'photo_url' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('users')->insert($users);
    }
}
