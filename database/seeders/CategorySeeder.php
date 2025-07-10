<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Infantry Weapons',
            'description' => 'Weapons designed for use by individual soldiers.',
            'icon' => 'https://res.cloudinary.com/dnnyocc5s/image/upload/v1751985715/infantry_icon.png'
        ]);
        Category::create([
            'name' => 'Artillery',
            'description' => 'Large-caliber guns used in warfare on land.',
            'icon' => 'https://res.cloudinary.com/dnnyocc5s/image/upload/v1751985715/artillery_icon.png'
        ]);
        Category::create([
            'name' => 'Aircraft',
            'description' => 'Military aircraft used for various combat roles.',
            'icon' => 'https://res.cloudinary.com/dnnyocc5s/image/upload/v1751985715/aircraft_icon.png'
        ]);
        Category::create([
            'name' => 'Naval Weapons',
            'description' => 'Weapons designed for use on naval vessels.',
            'icon' => 'https://res.cloudinary.com/dnnyocc5s/image/upload/v1751985715/naval_icon.png'
        ]);
    }
}
