<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Models\Patient;

use Illuminate\Http\Request;

class MedicalHistoryController extends Controller
{
    // Mostrar todos los historiales clínicos
    public function index()
    {
        $medicalHistories = MedicalHistory::all();
        return response()->json($medicalHistories);
    }

    // Crear un nuevo historial clínico
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'created_at' => 'nullable|date',
        ]);

        $medicalHistory = MedicalHistory::create($validated);

        return response()->json($medicalHistory, 201);
    }

    // Mostrar un historial clínico específico
    public function show($id)
    {
        $medicalHistory = MedicalHistory::find($id);

        if (!$medicalHistory) {
            return response()->json(['error' => 'Medical History not found'], 404);
        }

        return response()->json($medicalHistory);
    }

    /**
     * Mostrar el historial clínico de un paciente por DNI y sus diagnósticos.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByDni(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|size:8',
        ]);

        $patient = Patient::where('dni', $request->dni)->first();

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

    // Actualizar un historial clínico
    public function update(Request $request, $id)
    {
        $medicalHistory = MedicalHistory::find($id);

        if (!$medicalHistory) {
            return response()->json(['error' => 'Medical History not found'], 404);
        }

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'created_at' => 'nullable|date',
        ]);

        $medicalHistory->update($validated);

        return response()->json($medicalHistory);
    }

    // Eliminar un historial clínico
    public function destroy($id)
    {
        $medicalHistory = MedicalHistory::find($id);

        if (!$medicalHistory) {
            return response()->json(['error' => 'Medical History not found'], 404);
        }

        $medicalHistory->delete();
        return response()->json(['message' => 'Medical History deleted successfully']);
    }
}
