<?php

namespace Database\Factories;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends Factory<Survey>
 */
class SurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
{
    return [
        'user_id' => User::factory(),
        'title' => fake()->sentence(3),
        'description' => fake()->sentence(),
        'status' => fake()->randomElement([
            'draft',
            'active',
            'closed',
            'archived'
        ]),
    ];
}
}
