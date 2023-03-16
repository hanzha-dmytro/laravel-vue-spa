<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::all()->random(),
            'name' => $this->faker->text(30),
            'slug' => $this->faker->slug,
            'description' => $this->faker->text(100),
            'content' => $this->faker->text,
            'is_visible' => true,
            'published_at' => $this->faker->dateTimeBetween('yesterday', 'tomorrow')
        ];
    }
}
