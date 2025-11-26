<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Mostrar todos los administradores
    public function index()
    {
        $admins = Admin::all();
        return response()->json($admins);
    }

    // Crear un nuevo administrador
    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|max:100',
            'responsible_area' => 'required|max:100',
            'user_id' => 'required|exists:users,id',
        ]);

        $admin = Admin::create($validated);

        return response()->json($admin, 201);
    }

    // Mostrar un administrador específico
    public function show($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        return response()->json($admin);
    }

    // Actualizar un administrador
    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        $validated = $request->validate([
            'position' => 'required|max:100',
            'responsible_area' => 'required|max:100',
            'user_id' => 'required|exists:users,id',
        ]);

        $admin->update($validated);

        return response()->json($admin);
    }

    // Eliminar un administrador
    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        $admin->delete();
        return response()->json(['message' => 'Admin deleted successfully']);
    }
}
