<?php

namespace Database\Seeders;

use App\Models\ContextBlock;
use App\Models\ContextTag;
use App\Models\Response;
use App\Models\Survey;
use App\Models\SurveyContext;
use App\Models\SurveyQuestion;
use App\Models\User;
use App\Models\Tag;
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
        // $data = [
        //     'users' => 30,
        //     'contexts' => 5,
        //     'surveys' => 5,
        //     'survey_questions' => 10,
        //     'responses' => 20
        // ];

        $makeUsers = function($num){
            User::factory($num)
            ->create();
        };

        $makeContexts = function($num = 5, $uid= null){
            SurveyContext::factory($num)
                ->user_init($uid)
                ->has(
                    ContextBlock::factory(fake()->numberBetween(3,10)),
                        'blocks'
                    )
                ->create();
        };

        $makeSurveys = function($num = 5, $cid = null) {

            Survey::factory($num)
                ->context_init($cid)
                ->has(
                    SurveyQuestion::factory(fake()->numberBetween(4, 8)),
                    'questions'
                )
                ->createQuietly();

        };

        $makeResponses = function($num=5, $sid=null){
            Response::factory($num)
            ->survey_init($sid)
            ->createQuietly();
        };

        $makeTags = function($num, $cid=null){
            for($i = 0; $i < $num; $i++){
                $context = $cid ? SurveyContext::find($cid) : SurveyContext::inRandomOrder()->first();
                $tag = Tag::inRandomOrder()->first();

                if(!ContextTag::where('context_id', $context->id)->where('tag_id',$tag->id)->exists()){
                    ContextTag::create([
                        'context_id' => $context->id,
                        'tag_id' => $tag->id
                    ]);
                }
            }
        };

        $mainR = function() use($makeUsers, $makeContexts, $makeSurveys, $makeResponses, $makeTags){
            $this->call([TagSeeder::class]);
            $makeUsers(30);

            foreach(User::get() as $user){
                $makeContexts(fake()->numberBetween(0,10), $user->id);
            }

            foreach(SurveyContext::get() as $context){
                $makeSurveys(fake()->numberBetween(2,10), $context->id);
                $makeTags(fake()->numberBetween(0,15));
            }

            foreach(Survey::get() as $survey){
                $makeResponses(fake()->numberBetween(10,100), $survey->id);
            }

        };

        $mainR();
    }
}
