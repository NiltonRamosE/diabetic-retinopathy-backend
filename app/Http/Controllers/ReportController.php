<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Mostrar todos los reportes
    public function index()
    {
        $reports = Report::all();
        return response()->json($reports);
    }

    // Crear un nuevo reporte
    public function store(Request $request)
    {
        $validated = $request->validate([
            'comments' => 'required|string|max:500',
            'image_id' => 'required|exists:images,id',
            'diagnosis_id' => 'required|exists:diagnoses,id',
        ]);

        $report = Report::create($validated);

        return response()->json($report, 201);
    }

    // Mostrar un reporte específico
    public function show($id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json(['error' => 'Report not found'], 404);
        }

        return response()->json($report);
    }

    // Actualizar un reporte
    public function update(Request $request, $id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json(['error' => 'Report not found'], 404);
        }

        $validated = $request->validate([
            'comments' => 'required|string|max:500',
            'image_id' => 'required|exists:images,id',
            'diagnosis_id' => 'required|exists:diagnoses,id',
        ]);

        $report->update($validated);

        return response()->json($report);
    }

    // Eliminar un reporte
    public function destroy($id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json(['error' => 'Report not found'], 404);
        }

        $report->delete();
        return response()->json(['message' => 'Report deleted successfully']);
    }
}
