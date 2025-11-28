<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Patient;

use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    // Mostrar todos los diagnósticos
    public function index()
    {
        $diagnoses = Diagnosis::all();
        return response()->json($diagnoses);
    }

    // Crear un nuevo diagnóstico
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:500',
            'history_id' => 'required|exists:medical_histories,id',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $diagnosis = Diagnosis::create($validated);

        return response()->json($diagnosis, 201);
    }

    // Mostrar un diagnóstico específico
    public function show($id)
    {
        $diagnosis = Diagnosis::find($id);

        if (!$diagnosis) {
            return response()->json(['error' => 'Diagnosis not found'], 404);
        }

        return response()->json($diagnosis);
    }

    /**
     * Mostrar todos los diagnósticos de un paciente por su ID, incluyendo información derivada como el doctor.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByPatientId($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $medicalHistory = $patient->medicalHistory;

        if (!$medicalHistory) {
            return response()->json(['error' => 'Medical history not found'], 404);
        }

        $diagnoses = $medicalHistory->diagnoses;

        $diagnosesWithDoctor = $diagnoses->map(function ($diagnosis) {
            $diagnosis->doctor = $diagnosis->doctor;
            return $diagnosis;
        });

        return response()->json([
            'patient' => $patient,
        ], 200);
    }

    // Actualizar un diagnóstico
    public function update(Request $request, $id)
    {
        $diagnosis = Diagnosis::find($id);

        if (!$diagnosis) {
            return response()->json(['error' => 'Diagnosis not found'], 404);
        }

        $validated = $request->validate([
            'description' => 'required|string|max:500',
            'history_id' => 'required|exists:medical_histories,id',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $diagnosis->update($validated);

        return response()->json($diagnosis);
    }

    // Eliminar un diagnóstico
    public function destroy($id)
    {
        $diagnosis = Diagnosis::find($id);

        if (!$diagnosis) {
            return response()->json(['error' => 'Diagnosis not found'], 404);
        }

        $diagnosis->delete();
        return response()->json(['message' => 'Diagnosis deleted successfully']);
    }
}
