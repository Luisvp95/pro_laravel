<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;

class CategoryFactory extends Factory
{
protected $model = Course ::class;
public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'image' => $this->faker->imageUrl(1280, 720),
            'description' => $this->faker->text(800),

            'user_id' => rand(1,5),
            'category_id' => rand(1,3),
        ];
    }
}
