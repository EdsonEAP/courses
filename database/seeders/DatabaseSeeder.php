<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\LevelSeeder;
use Database\Seeders\PriceSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Edson Alvarado ',
             'email' => 'edsonap2001@gmail.com',
                'password' => bcrypt('edson')
         ]);

         $this->call([
             CategorySeeder::class,
             LevelSeeder::class,
             PriceSeeder::class,

         ]);
    }
}
