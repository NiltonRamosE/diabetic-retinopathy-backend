<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => ['required', Rule::in(['patient', 'doctor', 'admin'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if (!$user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        if ($user->user_type !== $request->role) {
            return response()->json([
                'status' => false,
                'message' => 'El rol no coincide con el seleccionado.'
            ], 403);
        }

        $token = $user->createToken('auth_token_' . $user->name)->plainTextToken;

        $profile = null;
        if ($user->user_type === 'doctor') {
            $profile = $user->doctor()->first();
        } elseif ($user->user_type === 'patient') {
            $profile = $user->patient()->first();
        } elseif ($user->user_type === 'admin') {
            $profile = $user->admin()->first();
        }

        $user->makeHidden(['password']);

        return response()->json([
            'status' => true,
            'message' => 'Login exitoso',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'profile' => $profile,
        ], 200);
    }
}
