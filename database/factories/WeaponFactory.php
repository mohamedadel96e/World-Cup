<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weapon>
 */
class WeaponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::inRandomOrder()->first()->id,
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'category_id' => Category::inRandomOrder()->first()->id,
            'base_price' => $this->faker->numberBetween(1000, 100000),
            'image_path' => "https://res.cloudinary.com/dnnyocc5s/image/upload/v1752005121/user-profiles/user_12.jpg",
            'discount_percentage' => $this->faker->numberBetween(20, 50),
            'is_available' => $this->faker->boolean(100),
            'is_featured' => $this->faker->boolean(60),
        ];
    }
}
