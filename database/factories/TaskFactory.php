<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'pending',
            'start_date' => $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'due_date' => $this->faker->dateTimeBetween($startDate, '+2 months'),
        ];
    }
}
