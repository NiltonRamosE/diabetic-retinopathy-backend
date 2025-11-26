<?php

namespace Database\Seeders;

use App\Models\Report;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 10 informes aleatorios
        Report::factory()->count(10)->create();
    }
}
