<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(30),
            'slug' => $this->faker->slug,
            'description' => $this->faker->text(300),
            'is_visible' => true,
        ];
    }
}
