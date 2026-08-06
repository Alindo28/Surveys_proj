<?php

namespace Database\Factories;

use App\Models\Survey;
use App\Models\SurveyContext;
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

protected $context;
public function definition(): array
{
    $context = $this->context ? $this->context : SurveyContext::inRandomOrder()->first();

    return [
        'context_id' => $context->id,
        'user_id' => $context->user_id,
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

public function context_init($id){
    $this->context = $id ? SurveyContext::find($id) : null;
    return $this;
}

}
