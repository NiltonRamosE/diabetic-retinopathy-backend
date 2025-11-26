<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MedicalHistorySeeder::class,
            AppointmentSeeder::class,
            CategorySeeder::class,
            ImageSeeder::class,
            DiagnosisSeeder::class,
            ReportSeeder::class,
        ]);
    }
}
