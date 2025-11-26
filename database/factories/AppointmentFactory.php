<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $patient = Patient::factory()->create();
        $doctor = Doctor::factory()->create();

        return [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'appointment_time' => $this->faker->time,
            'reason' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['pending', 'completed', 'canceled']),
        ];
    }
}
