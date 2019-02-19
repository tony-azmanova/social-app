<?php

use Illuminate\Database\Seeder;
use Spatie\Seeders\StringSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            RolesAndPermissionsTableSeeder::class,
            CommentsTableSeeder::class,
            ReactionsTableSeeder::class,
            GalleriesTableSeeder::class,
            FilesTableSeeder::class,
            ImagesTableSeeder::class
        ]);
    }
}
