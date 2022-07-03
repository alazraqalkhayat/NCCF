<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dose>
 */
class DoseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'type' => rand(1, 2),
            // 'patient' => rand(1, 2),
            'status' => rand(1,3)

        ];
    }
}
