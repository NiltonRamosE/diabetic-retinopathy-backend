<?php
namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        $user = User::factory()->patient()->create();

        return [
            'user_id' => $user->id,
            'birth_date' => $this->faker->date(),
            'dni' => $this->faker->unique()->numerify('########'),
        ];
    }
}
