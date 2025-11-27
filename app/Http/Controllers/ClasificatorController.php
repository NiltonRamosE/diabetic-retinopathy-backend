<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            $response = Http::attach('image', file_get_contents($image), $image->getClientOriginalName())
                ->post($microserviceUrl . '/classify');

            if ($response->successful()) {
                return response()->json([
                    'prediction' => $response->json()['prediction'],
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
}
