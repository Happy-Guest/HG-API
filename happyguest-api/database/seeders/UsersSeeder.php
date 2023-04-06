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
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tomás Neves',
                'email' => 'tomasn@happyguest.pt',
                'phone' => '966938453',
                'password' => bcrypt('123456789'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('users')->insert($users);
    }
}
