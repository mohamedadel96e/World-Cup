<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'name' => 'Axis',
            'description' => 'The Axis powers, led by Germany, Italy, and Japan, fought against the Allies in World War II.',
            'logo' => 'axis_logo.png',
        ]);

        Team::create([
            'name' => 'Allies',
            'description' => 'The Allies, including the United States, Soviet Union, and United Kingdom, opposed the Axis powers.',
            'logo' => 'allies_logo.png',
        ]);
        Team::create([
            'name' => 'Neutral',
            'description' => 'Countries that remained neutral during the war, such as Switzerland.',
            'logo' => 'neutral_logo.png',
        ]);
    }
}
