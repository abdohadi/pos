<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        $this->call(UsersTableSeeder::class);

        // create some clients, categories and products when running db:seed command
        factory('App\Client', 3)->create();
        factory('App\Product', 5)->create();    // will create a category for each product
    }
}
