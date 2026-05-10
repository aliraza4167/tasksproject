<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
            'title' => str(fake()->realText(30))->beforeLast('.')->title(),
            'description' => fake()->realText(100),
            'is_completed' => $this->faker->boolean,
            'due_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'user_id' => User::factory(),
        ];
    }
}
