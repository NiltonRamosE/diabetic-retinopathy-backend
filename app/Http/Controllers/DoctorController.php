<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // Mostrar todos los médicos
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json($doctors);
    }

    // Crear un nuevo médico
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cmp' => 'required|unique:doctors,cmp|size:15',
            'specialty' => 'required|max:80',
            'user_id' => 'required|exists:users,id',
        ]);

        $doctor = Doctor::create($validated);

        return response()->json($doctor, 201);
    }

    // Mostrar un médico específico
    public function show($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        return response()->json($doctor);
    }

    // Actualizar un médico
    public function update(Request $request, $id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        $validated = $request->validate([
            'cmp' => 'required|unique:doctors,cmp,' . $id . '|size:15',
            'specialty' => 'required|max:80',
            'user_id' => 'required|exists:users,id',
        ]);

        $doctor->update($validated);

        return response()->json($doctor);
    }

    // Eliminar un médico
    public function destroy($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        $doctor->delete();
        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}
