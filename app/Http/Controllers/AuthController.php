<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
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

    /**
     * Registro de usuario: recibe los datos generales del usuario y los datos específicos del rol.
     * Crea el usuario y su perfil relacionado.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',  // Confirma la contraseña
            'role' => ['required', Rule::in(['admin', 'doctor', 'patient'])],

            'admin_fields' => 'nullable|required_if:role,admin|array',
            'admin_fields.position' => 'nullable|required_if:role,admin|string|max:255',
            'admin_fields.responsible_area' => 'nullable|required_if:role,admin|string|max:255',

            'doctor_fields' => 'nullable|required_if:role,doctor|array',
            'doctor_fields.cmp' => 'nullable|required_if:role,doctor|string|max:255',
            'doctor_fields.specialty' => 'nullable|required_if:role,doctor|string|max:255',

            'patient_fields' => 'nullable|required_if:role,patient|array',
            'patient_fields.dni' => 'nullable|required_if:role,patient|string|max:255',
            'patient_fields.birth_date' => 'nullable|required_if:role,patient|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->role,
        ]);

        if ($request->role === 'admin') {
            $admin = Admin::create([
                'user_id' => $user->id,
                'position' => $request->admin_fields['position'],
                'responsible_area' => $request->admin_fields['responsible_area'],
            ]);
        } elseif ($request->role === 'doctor') {
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'cmp' => $request->doctor_fields['cmp'],
                'specialty' => $request->doctor_fields['specialty'],
            ]);
        } elseif ($request->role === 'patient') {
            $patient = Patient::create([
                'user_id' => $user->id,
                'dni' => $request->patient_fields['dni'],
                'birth_date' => $request->patient_fields['birth_date'],
            ]);
        }

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
            'message' => 'Registro exitoso',
            'user' => $user,
            'profile' => $profile,
        ], 201);
    }
}
