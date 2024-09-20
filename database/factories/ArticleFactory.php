<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('fa_IR');
        return [
            'name' => $faker->sentence(),
           'description' => $faker->paragraph(),
           'text' => $faker->sentence(1000),
           'cover' => 'https://picsum.photos/400',
           'category_id' => rand(1, 10),
           'user_id' => 1,
           'likes' => rand(1, 100),



        ];
    }
}
