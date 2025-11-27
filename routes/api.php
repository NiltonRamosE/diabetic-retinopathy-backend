<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CorsMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ReportController;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('medical-histories', MedicalHistoryController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('images', ImageController::class);
    Route::resource('diagnoses', DiagnosisController::class);
    Route::resource('reports', ReportController::class);
});
