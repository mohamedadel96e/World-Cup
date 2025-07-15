<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Weapon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockpileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = Country::all();
        $weapons = Weapon::all();

        foreach ($countries as $country) {
            foreach ($weapons as $weapon) {
                if ($weapon->country_id === $country->id) {

                    $country->weapons()->attach($weapon->id, ['quantity' => rand(1, 100)]);
                }

                else if (rand(1, 4) === 1) {
                    // Attach weapon to country with a random quantity
                    $country->weapons()->attach($weapon->id, ['quantity' => rand(1, 100)]);
                }
            }
        }
    }
}
