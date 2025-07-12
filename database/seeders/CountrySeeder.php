<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the team IDs first to ensure they exist
        $axisTeam = Team::where('name', 'Axis')->first();
        $alliesTeam = Team::where('name', 'Allies')->first();
        $neutralTeam = Team::where('name', 'Neutral')->first();

        // Check if teams were found before proceeding
        if (!$axisTeam || !$alliesTeam || !$neutralTeam) {
            $this->command->error('Teams not found. Please run the TeamSeeder first.');
            return;
        }

        Country::create([
            'team_id' => $axisTeam->id,
            'name' => 'Germany',
            'code' => 'RMK',
            'currency_name' => 'Reichsmark',
            'flag' => 'https://res.cloudinary.com/dnnyocc5s/image/upload/v1751985715/germany_flag_cbpyua.png',
            'logo' => 'https://res.cloudinary.com/dnnyocc5s/image/upload/v1751985715/germany_sqvpql.svg',
            'currency_code' => 'RMK',
            'currency_symbol' => 'RM'
        ]);

        Country::create([
            'team_id' => $axisTeam->id,
            'name' => 'Egypt',
            'code' => 'EGY',
            'currency_name' => 'Egyptian Pound',
            'flag' => 'https://res.cloudinary.com/dnnyocc5s/image/upload/v1752003279/circle_qbn9vx.png',
            'currency_code' => 'EGP',
            'currency_symbol' => 'E£'
        ]);

        Country::create([
            'team_id' => $alliesTeam->id,
            'name' => 'United Kingdom',
            'code' => 'GBR',
            'currency_name' => 'Pound Sterling',
            'flag' => 'https://res.cloudinary.com/dnnyocc5s/image/upload/v1751985715/uk_flag_g8dnis.png',
            'currency_code' => 'GBP',
            'currency_symbol' => '£'
        ]);

        Country::create([
            'team_id' => $alliesTeam->id,
            'name' => 'Soviet Union',
            'code' => 'SUR',
            'flag' => 'https://res.cloudinary.com/dnnyocc5s/image/upload/v1751985716/russia_flag_pnmj50.png',
            'currency_name' => 'Soviet Ruble',
            'currency_code' => 'SUR',
            'currency_symbol' => '₽'
        ]);

        Country::create([
            'team_id' => $alliesTeam->id,
            'name' => 'Switzerland',
            'code' => 'CHE',
            'flag' => 'https://res.cloudinary.com/dnnyocc5s/image/upload/v1751985715/switzerland_flag_ulpakv.png',
            'currency_name' => 'Swiss Franc',
            'currency_code' => 'CHF',
            'currency_symbol' => 'CHF'
        ]);
    }
}
