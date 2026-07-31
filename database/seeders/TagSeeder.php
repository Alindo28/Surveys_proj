<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = "education, school, university, college, learning, students, teaching, technology, programming, computer science, artificial intelligence, AI, machine learning, software, hardware, cybersecurity, web development, mobile apps, business, entrepreneurship, marketing, finance, accounting, economics, startups, leadership, sales, management, health, mental health, fitness, nutrition, exercise, wellness, healthcare, psychology, science, biology, chemistry, physics, mathematics, engineering, astronomy, environment, climate, sports, soccer, basketball, baseball, hockey, football, tennis, swimming, running, esports, gaming, movies, television, music, books, anime, podcasts, streaming, travel, food, cooking, fashion, shopping, photography, pets, family, lifestyle, politics, government, law, culture, religion, ethics, community, diversity, news, career, jobs, internship, co-op, workplace, productivity, remote work, networking, resume, interview, customer satisfaction, feedback, user experience, product testing, poll, preferences, opinion, questionnaire, rating, survey, teenagers, adults, parents, teachers, developers, professionals, beginners, experts, seniors, holiday, christmas, halloween, valentine's day, summer, winter, conference, workshop, event";

        foreach(explode(', ', $tags) as $tag){
            Tag::firstOrCreate([
                'name' => $tag,
                'slug' => Str::slug($tag)
            ]);
        }
    }
}
