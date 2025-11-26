<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    // Mostrar todas las imágenes
    public function index()
    {
        $images = Image::all();
        return response()->json($images);
    }

    // Subir una nueva imagen
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file_name' => 'required|string|max:200',
            'path' => 'required|string|max:400',
            'resolution' => 'nullable|string|max:50',
            'doctor_id' => 'required|exists:doctors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $image = Image::create($validated);

        return response()->json($image, 201);
    }

    // Mostrar una imagen específica
    public function show($id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        return response()->json($image);
    }

    // Actualizar una imagen
    public function update(Request $request, $id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        $validated = $request->validate([
            'file_name' => 'required|string|max:200',
            'path' => 'required|string|max:400',
            'resolution' => 'nullable|string|max:50',
            'doctor_id' => 'required|exists:doctors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $image->update($validated);

        return response()->json($image);
    }

    // Eliminar una imagen
    public function destroy($id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        $image->delete();
        return response()->json(['message' => 'Image deleted successfully']);
    }
}
