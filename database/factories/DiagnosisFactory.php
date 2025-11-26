<?php

namespace Database\Factories;

use App\Models\Diagnosis;
use App\Models\MedicalHistory;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiagnosisFactory extends Factory
{
    protected $model = Diagnosis::class;

    public function definition(): array
    {
        $medicalHistory = MedicalHistory::factory()->create();
        $doctor = Doctor::factory()->create();

        return [
            'description' => $this->faker->sentence,
            'history_id' => $medicalHistory->id,
            'doctor_id' => $doctor->id,
            'diagnosis_date' => $this->faker->dateTimeThisYear,
        ];
    }
}
