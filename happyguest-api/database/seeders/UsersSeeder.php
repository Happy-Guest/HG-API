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
            // Admins
            [
                'name' => 'Diogo Mendes',
                'email' => 'diiogom21@happyguest.pt',
                'phone' => '914310511',
                'password' => bcrypt('123456789'),
                'address' => null,
                'birth_date' => '2001-08-01',
                'role' => 'A',
                'blocked' => false,
                'photo_url' => null,
                'last_review' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tomás Neves',
                'email' => 'tomasn@happyguest.pt',
                'phone' => '966938453',
                'password' => bcrypt('123456789'),
                'address' => null,
                'birth_date' => '2002-06-14',
                'role' => 'A',
                'blocked' => false,
                'photo_url' => null,
                'last_review' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Managers
            [
                'name' => 'João Silva',
                'email' => 'joaos@email.pt',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'address' => null,
                'birth_date' => null,
                'role' => 'M',
                'blocked' => false,
                'photo_url' => null,
                'last_review' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Andreia Santos',
                'email' => 'andreia_santos@email.pt',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'address' => 'Rua da Alegria, nº123 Lisboa',
                'birth_date' => null,
                'role' => 'M',
                'blocked' => false,
                'photo_url' => null,
                'last_review' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Clients
            [
                'name' => 'Ana Rodrigues',
                'email' => 'anar@mail.com',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'address' => null,
                'birth_date' => null,
                'role' => 'C',
                'blocked' => true,
                'photo_url' => null,
                'last_review' => '2023-01-26 14:25',
                'created_at' => '2023-01-24 12:03:01',
                'updated_at' => $now,
            ],
            [
                'name' => 'Daniel Santos',
                'email' => 'dani@email.pt',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'address' => 'Avenida da Liberdade, nº3 Lisboa',
                'birth_date' => null,
                'role' => 'C',
                'blocked' => false,
                'photo_url' => null,
                'last_review' => null,
                'created_at' => '2023-02-13 17:11:23',
                'updated_at' => $now,
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria@email.pt',
                'phone' => '924738372',
                'password' => bcrypt('123456789'),
                'address' => null,
                'birth_date' => '1999-03-12',
                'role' => 'C',
                'blocked' => false,
                'photo_url' => null,
                'last_review' => '2023-04-03 21:12',
                'created_at' => '2023-03-26 09:23:12',
                'updated_at' => $now,
            ],
            [
                'name' => 'José Costa',
                'email' => 'josec@hotmail.com',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'address' => null,
                'birth_date' => null,
                'role' => 'C',
                'blocked' => false,
                'photo_url' => null,
                'last_review' => null,
                'created_at' => '2023-03-30 14:23:12',
                'updated_at' => $now,
            ],
            [
                'name' => 'Marta Pereira',
                'email' => 'martap@mail.pt',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'address' => 'Rua principal nº23, Meirinhas Pombal',
                'birth_date' => null,
                'role' => 'C',
                'blocked' => false,
                'photo_url' => null,
                'last_review' => null,
                'created_at' => '2023-04-15 11:23:12',
                'updated_at' => $now,
            ],
            [
                'name' => 'Rui Pereira',
                'email' => 'rpereira@mail.pt',
                'phone' => null,
                'password' => bcrypt('123456789'),
                'address' => null,
                'birth_date' => null,
                'role' => 'C',
                'blocked' => false,
                'photo_url' => null,
                'last_review' => '2023-04-23 11:34',
                'created_at' => '2023-04-16 23:12:02',
                'updated_at' => $now,
            ],
            [
                'name' => 'David Silva',
                'email' => 'davsilva@hotmail.com',
                'phone' => '925035705',
                'password' => bcrypt('123456789'),
                'address' => null,
                'birth_date' => null,
                'role' => 'C',
                'blocked' => false,
                'photo_url' => null,
                'last_review' => $now,
                'created_at' => $now->sub(new \DateInterval('P3D'))->format('Y-m-d H:i:s'),
                'updated_at' => $now,
            ],
        ];

        DB::table('users')->insert($users);
    }
}
