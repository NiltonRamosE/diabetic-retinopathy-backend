<?php

namespace Database\Factories;

use App\Models\MedicalHistory;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalHistoryFactory extends Factory
{
    protected $model = MedicalHistory::class;

    public function definition(): array
    {
        $patient = Patient::factory()->create();

        return [
            'patient_id' => $patient->id,
            'created_at' => $this->faker->dateTimeThisDecade,
        ];
    }
}
