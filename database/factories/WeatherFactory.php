<?php

namespace Database\Factories;

use App\Models\Weather;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weather>
 */
class WeatherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city' => fake()->unique()->city(),
            'lat' => fake()->randomFloat(),
            'lon' => fake()->randomFloat(),
            'data_weather' => ['key' => fake()->randomNumber()]
        ];
    }
}
