<?php

namespace Database\Factories;

use App\Models\ContextBlock;
use App\Models\SurveyContext;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContextBlock>
 */
class ContextBlockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['text', 'image']);
        $val= $type == 'text' ? fake()->paragraph(fake()->numberBetween(2,8)) : "https://loremflickr.com/700/400/" + fake()->word();

        return [
            'context_id' => SurveyContext::factory(),
            'type' => $type,
            'value' => $val
        ];
    }
}
