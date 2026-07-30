<?php

namespace Database\Seeders;

use App\Models\ContextBlock;
use App\Models\Response;
use App\Models\Survey;
use App\Models\SurveyContext;
use App\Models\SurveyQuestion;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $makeUsers = function(){
            User::factory(30)
            ->has(
                SurveyContext::factory(fake()->numberBetween(2,6))
                    ->has(
                        ContextBlock::factory(fake()->numberBetween(3,10)),
                        'blocks'
                    ),
                    'contexts'
                )
            ->create();
        };

        $makeSurveys = function($num = 5) {

            Survey::factory($num)
                ->has(
                    SurveyQuestion::factory(fake()->numberBetween(4, 8)),
                    'questions'
                )
                ->createQuietly();

        };

        $makeResponses = function($num=30){
            Response::factory($num)->createQuietly();
        };

        $mainR = function() use($makeUsers, $makeSurveys, $makeResponses){
            // $makeUsers();

            // for($i = 0; $i < 100; $i++)$makeSurveys();

            for($i = 0; $i < 100; $i++)$makeResponses();
        };

        $mainR();
    }
}
