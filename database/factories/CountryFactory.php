<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => 1,
            'name' => $this->faker->unique()->country(),
            'code' => $this->faker->unique()->countryCode(),
            'currency_name' => $this->faker->currencyCode() . ' Dollar',
            'currency_code' => $this->faker->unique()->currencyCode(),
            'currency_symbol' => $this->faker->randomElement(['$', '€', '£', '¥', '₽', '₹', '₩', '₺', '₪', '₫']),
            'logo' => $this->faker->imageUrl(200, 200, 'flags', true, 'Logo'),
            'flag' => $this->faker->imageUrl(200, 120, 'flags', true, 'Flag'),
        ];
    }
}
