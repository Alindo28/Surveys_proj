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

    protected $user;
    public function definition(): array
    {
        return [
            'user_id' => $this->user ? $this->user->id : User::inRandomOrder()->first(),
            'title' => fake()->sentence(),
            'preview' => fake()->sentences(4, true),
        ];
    }

    public function user_init($id){
        $this->user = $id ? User::find($id) : null;
        return $this;
    }
}
