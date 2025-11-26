<?php
namespace Database\Seeders;

use App\Models\MedicalHistory;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class MedicalHistorySeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();

        if ($patients->isEmpty()) {
            echo "No se encontraron pacientes para crear historiales médicos.\n";
            return;
        }

        foreach ($patients->take(20) as $patient) {
            MedicalHistory::factory()->create([
                'patient_id' => $patient->id,
            ]);
        }
    }
}
