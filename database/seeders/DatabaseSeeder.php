<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TeamSeeder::class,
        ]);

        // User::factory(10)->create();
        $this->call([
            CountrySeeder::class,
        ]);
        $this->call([
            CategorySeeder::class,
        ]);
        $this->call([
            WeaponSeeder::class,
        ]);
        User::factory()->count(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'country_id' => 1, // Assuming 1 is the ID for Germany
        ]);

        $this->call([
            StockpileSeeder::class,
        ]);


    }
}
