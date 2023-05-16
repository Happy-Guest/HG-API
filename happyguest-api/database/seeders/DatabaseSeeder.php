<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            CodesSeeder::class,
            UserCodesSeeder::class,
            ComplaintsSeeder::class,
        ]);

        // Delete all files from public storage
        $files = glob(public_path('storage/user_photos/*'));
        $files = array_merge($files, glob(public_path('storage/complaint_files/*')));
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            } else {
                File::deleteDirectory($file);
            }
        }
    }
}
