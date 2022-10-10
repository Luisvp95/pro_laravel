<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class CategoryFactory extends Factory
{
protected $model = Post ::class;
 public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'free' => rand(0,1),

            'course_id' => rand(1,10)
        ];
    }
}
