<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Patient;
use App\Models\MedicalHistory;
use App\Models\Diagnosis;

class ClasificatorController extends Controller
{
    /**
     * Clasifica la imagen utilizando el microservicio de deep learning.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function classifyImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');

        if (!$image) {
            return response()->json(['error' => 'No image provided'], 400);
        }

        $microserviceUrl = env('MICROSERVICIO_DEEP_LEARNIG');

        try {
            $response = Http::attach(
                'image',
                file_get_contents($image),
                $image->getClientOriginalName()
            )->post($microserviceUrl . '/classify');

            if ($response->successful()) {
                $data = $response->json();

                if (!isset($data['prediction']['label']) || !isset($data['prediction']['confidence'])) {
                    return response()->json([
                        'error' => 'Invalid prediction structure received from microservice',
                        'received' => $data
                    ], 500);
                }

                return response()->json([
                    'prediction' => $data['prediction'],
                ], 200);
            }

            return response()->json([
                'error' => 'Error al clasificar la imagen',
                'message' => $response->json(),
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Error al hacer la solicitud al microservicio: ' . $e->getMessage());

            return response()->json([
                'error' => 'Error en la comunicación con el microservicio',
            ], 500);
        }
    }


    public function generateReport(Request $request)
    {
        $validated = $request->validate([
            'dni' => 'required|string',
            'doctor_id' => 'required|exists:doctors,id',
            'description' => 'required|string|max:500',
        ]);

        $patient = Patient::where('dni', $validated['dni'])->first();

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $medicalHistory = $patient->medicalHistory;

        if (!$medicalHistory) {
            $medicalHistory = MedicalHistory::create([
                'patient_id' => $patient->id,
                'created_at' => now(),
            ]);
        }

        $diagnosis = Diagnosis::create([
            'description' => $validated['description'],
            'history_id' => $medicalHistory->id,
            'doctor_id' => $validated['doctor_id'],
        ]);

        return response()->json([
            'message' => 'Medical history and diagnosis generated successfully.',
            'medical_history' => $medicalHistory,
            'diagnosis' => $diagnosis,
        ], 201);
    }
}
