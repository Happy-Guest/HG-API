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
            ReviewsSeeder::class,
            CheckoutsSeeder::class,
        ]);

        // Delete all files from public storage and storage
        $files = glob(storage_path('app/public/user_photos/*'));
        $files = array_merge($files, glob(storage_path('app/complaint_files/*')));
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            } else {
                File::deleteDirectory($file);
            }
        }
    }
}
