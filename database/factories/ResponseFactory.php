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

    protected $survey;
    public function definition(): array
    {
        $survey = $this->survey ? $this->survey : Survey::inRandomOrder()->with('questions')->first();

        $answers = [];

        foreach($survey->questions as $question){
            if($question['type'] == 'text'){
                $answers[$question['id']] = fake()->sentence();
            }
            else if($question['type'] == 'choice'){
               $answers[$question['id']] = fake()->randomElement($question['options']);
            }
            else if($question['type'] == 'select'){
                $answers[$question['id']] = fake()->randomElements($question['options'], fake()->numberBetween(1,count($question->options)-1));
            }
            else if($question['type'] == 'slider'){
                $answers[$question['id']] = fake()->numberBetween($question['options']['start'],$question['options']['end']);
            }
        }

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'survey_id' => $survey->id,
            'answers' => $answers,
            'duration' => fake()->numberBetween(30,300)
        ];

    }

    public function survey_init($id){
        $this->survey = $id ? Survey::find($id) : null;
        return $this;
    }
}
