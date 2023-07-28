<?php

namespace Database\Seeders;

use App\Models\Region;
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
            HotelsSeeder::class,
            RegionsSeeder::class,
            UsersSeeder::class,
            CodesSeeder::class,
            UserCodesSeeder::class,
            ComplaintsSeeder::class,
            ReviewsSeeder::class,
            CheckoutsSeeder::class,
            ServicesSeeder::class,
            ReservesSeeder::class,
            ItemsSeeder::class,
            OrdersSeeder::class,
            ServiceItemsSeeder::class,
            OrderItemsSeeder::class,
        ]);

        // Delete all files from public storage and storage
        $files = glob(storage_path('app/public/user_photos/*'));
        $files = array_merge($files, glob(storage_path('app/complaint_files/*')));
        $files = array_merge($files, glob(storage_path('app/public/services/*')));
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            } else {
                File::deleteDirectory($file);
            }
        }

        // Create parent folder if it doesn't exist
        if (!is_dir(storage_path('app/public'))) {
            mkdir(storage_path('app/public'));
        }

        // Create services folder
        if (!is_dir(storage_path('app/public/services'))) {
            mkdir(storage_path('app/public/services'));
        }


        // Populate services folder from storage
        $services = scandir(storage_path('app/services'));
        foreach ($services as $service) {
            if ($service !== '.' && $service !== '..') {
                copy(storage_path('app/services/' . $service), storage_path('app/public/services/' . $service));
            }
        }
    }
}
