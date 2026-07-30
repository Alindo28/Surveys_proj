<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\SurveyContext;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SurveyContext>
 */
class SurveyContextFactory extends Factory
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
            'title' => fake()->sentence(),
            'preview' => fake()->sentences(4, true),
        ];
    }
}
