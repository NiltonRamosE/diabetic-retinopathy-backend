<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
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
