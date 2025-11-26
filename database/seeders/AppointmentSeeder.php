<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 30 citas aleatorias entre pacientes y doctores
        Appointment::factory()->count(30)->create();
    }
}
