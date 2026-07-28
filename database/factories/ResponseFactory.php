<?php

namespace Database\Factories;

use App\Models\Response;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Pail\ValueObjects\Origin\Console;
use Laravel\Prompts\Output\ConsoleOutput;

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
            else if($question['type'] == 'choice'){
               $answers[] = fake()->randomElement(explode('|', $question['options']));
            }
            else if($question['type'] == 'select'){
                $answers[] = implode(',', fake()->randomElements(explode('|', $question['options']), random_int(1,3))) ;
            }
            else if($question['type'] == 'slider'){
                $range = explode('|', $question['options']);
                $answers[] = fake()->numberBetween($range[0],$range[1]);
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
