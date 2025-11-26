<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Mostrar todos los pacientes
    public function index()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }

    // Crear un nuevo paciente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'birth_date' => 'required|date',
            'dni' => 'required|unique:patients,dni|size:8',
            'user_id' => 'required|exists:users,id',
        ]);

        $patient = Patient::create($validated);

        return response()->json($patient, 201);
    }

    // Mostrar un paciente específico
    public function show($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }

    // Actualizar un paciente
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $validated = $request->validate([
            'birth_date' => 'required|date',
            'dni' => 'required|unique:patients,dni,' . $id . '|size:8',
            'user_id' => 'required|exists:users,id',
        ]);

        $patient->update($validated);

        return response()->json($patient);
    }

    // Eliminar un paciente
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $patient->delete();
        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
