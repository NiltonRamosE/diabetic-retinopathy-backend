<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory(10)->create()->each(function ($user) {
            if ($user->user_type == 'admin') {
                Admin::factory()->create(['user_id' => $user->id]);
            } elseif ($user->user_type == 'doctor') {
                Doctor::factory()->create(['user_id' => $user->id]);
            } elseif ($user->user_type == 'patient') {
                Patient::factory()->create(['user_id' => $user->id]);
            }
        });
    }
}
