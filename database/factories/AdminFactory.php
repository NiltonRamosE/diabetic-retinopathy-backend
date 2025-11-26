<?php
namespace Database\Factories;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition(): array
    {
        $user = User::factory()->admin()->create();

        return [
            'user_id' => $user->id,
            'position' => $this->faker->word,
            'responsible_area' => $this->faker->word,
        ];
    }
}
