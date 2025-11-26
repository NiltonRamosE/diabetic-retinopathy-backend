<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ReportController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


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
