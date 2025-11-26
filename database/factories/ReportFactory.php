<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\Image;
use App\Models\Diagnosis;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        $image = Image::factory()->create();
        $diagnosis = Diagnosis::factory()->create();

        return [
            'comments' => $this->faker->paragraph,
            'image_id' => $image->id,
            'diagnosis_id' => $diagnosis->id,
        ];
    }
}
