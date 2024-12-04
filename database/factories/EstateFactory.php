<?php

namespace Database\Factories;

use App\Models\Estate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estate>
 */
class EstateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rooms = fake()->numberBetween(1, 10);
        $estate = [
            'user_id' => fake()->numberBetween(1, 30),
            'price' => fake()->numberBetween(10000, 1000000),
            'currency_code' => fake()->randomElement(['BGN', 'EUR', 'USD']),
            'type' => fake()->randomElement(['land', 'house', 'floor', 'apartment']),
            'construction_type' => fake()->randomElement(
                ['concrete', 'epk', 'stone', 'brick', 'metal', 'wood', 'clay']
            ),
            'construction_date' => Carbon::now()
                ->subYears(fake()->numberBetween(0, 50))
                ->toDateTimeString(),
            'rooms' => $rooms,
            'bathrooms' => fake()->numberBetween(1, $rooms),
            'land_size' => fake()->numberBetween(100, 65000),
            'building_size' => fake()->numberBetween(40, 600),
            'region' => fake()->randomElement(['Sofia', 'Plovdiv', 'Varna']),
            'city' => fake()->randomElement(['Sofia', 'Plovdiv', 'Varna', null]),
            'description' => fake()->sentences(fake()->numberBetween(1, 10), true),
        ];

        if ($estate['type'] !== 'land') {
            $estate['floors'] = fake()->numberBetween(1, 6);
            if ($estate['type'] !== 'house') {
                $estate['floor_number'] = fake()->numberBetween(1, $estate['floors']);
                $estate['land_size'] = null;
            }
        } else {
            $estate['rooms'] = null;
            $estate['bathrooms'] = null;
            $estate['building_size'] = null;
            $estate['construction_type'] = null;
            $estate['construction_date'] = null;
        }

        if (!isset($estate['city'])) {
            $estate['village'] = fake()->randomElement(['Gradec', 'Markovo', 'Razdelna']);
        }

        return $estate;
    }
}
