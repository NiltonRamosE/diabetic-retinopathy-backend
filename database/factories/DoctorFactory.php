<?php
namespace Database\Factories;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        $user = User::factory()->doctor()->create();

        return [
            'user_id' => $user->id,
            'cmp' => $this->faker->unique()->numberBetween(1000, 9999),
            'specialty' => $this->faker->word,
        ];
    }
}
