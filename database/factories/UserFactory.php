<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'user_type' => $this->faker->randomElement(['admin', 'doctor', 'patient']),
        ];
    }

    public function admin(): self
    {
        return $this->state([
            'user_type' => 'admin',
        ]);
    }

    public function doctor(): self
    {
        return $this->state([
            'user_type' => 'doctor',
        ]);
    }

    public function patient(): self
    {
        return $this->state([
            'user_type' => 'patient',
        ]);
    }
}
