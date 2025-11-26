<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Doctor;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        $doctor = Doctor::factory()->create();
        $category = Category::factory()->create();

        return [
            'file_name' => $this->faker->word . '.jpg',
            'path' => $this->faker->imageUrl(),
            'resolution' => $this->faker->randomElement(['1920x1080', '1280x720', '1024x768']),
            'doctor_id' => $doctor->id,
            'category_id' => $category->id,
        ];
    }
}
