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
        'choice',
        'select',
        'slider'
    ]);

    return [
        'survey_id' => Survey::factory(),
        'question' => fake()->sentence(),
        'type' => $type,

        // Your database stores options as a string separated by |
        'options' => match ($type) {
            'choice', 'select' => implode('|', fake()->randomElements([
                'Option A',
                'Option B',
                'Option C',
                'Option D',
                'Option E',
                'Option F',
            ], random_int(3, 6))),
            'slider' => '0|10',
            default => null,
        },


        'required' => fake()->boolean(),
        'private' => fake()->boolean(),
    ];
}
}
