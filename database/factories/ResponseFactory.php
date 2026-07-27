<?php

namespace Database\Factories;

use App\Models\Response;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Response>
 */
class ResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $survey = Survey::inRandomOrder()->with('questions')->first();

        $answers = [];

        foreach($survey['questions'] as $question){
            if($question['type'] == 'text'){
                $answers[] = fake()->sentence();
            }
            else{
               $answers[] = fake()->randomElement(explode('|', $question['options']));
            }
        }

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'survey_id' => $survey->id,
            'answers' => implode('|',$answers),
            'duration' => fake()->numberBetween(30,300)
        ];
    }
}
