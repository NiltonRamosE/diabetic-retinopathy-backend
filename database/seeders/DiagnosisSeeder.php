<?php

namespace Database\Seeders;

use App\Models\Diagnosis;
use Illuminate\Database\Seeder;

class DiagnosisSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 15 diagnósticos aleatorios
        Diagnosis::factory()->count(15)->create();
    }
}
