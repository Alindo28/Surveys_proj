<?php

namespace Database\Factories;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SurveyQuestion>
 */
class SurveyQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
{
    $type = fake()->randomElement([
        'text',
        'choice'
    ]);

    return [
        'survey_id' => Survey::factory(),
        'question' => fake()->sentence(),
        'type' => $type,

        // Your database stores options as a string separated by |
        'options' => $type === 'choice'
            ? implode('|', fake()->randomElements([
                'Option A',
                'Option B',
                'Option C',
                'Option D'
            ], 3))
            : null,

        'required' => fake()->boolean(),
        'position' => fake()->numberBetween(0,10),
    ];
}
}
