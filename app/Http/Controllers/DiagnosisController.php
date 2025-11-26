<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
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
