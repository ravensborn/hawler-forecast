<?php

use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\IncidentTypeController;
use App\Http\Controllers\Api\MapPinController;
use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\Api\SensorDeviceGroupController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Route::prefix('auth')->name('auth.')->group(function () {
//    Route::post('token', [AuthController::class, 'createToken'])->name('create-token');
//    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
//    Route::post('verify-reset-code', [AuthController::class, 'verifyResetCode'])->name('verify-reset-code');
//    Route::post('reset-password-with-token', [AuthController::class, 'resetPasswordWithToken'])->name('reset-password-with-token');
// });

Route::get('alerts', [AlertController::class, 'index'])->name('alerts.index');
Route::get('map-pins', [MapPinController::class, 'index'])->name('map-pins.index');
Route::get('sensor-device-groups', [SensorDeviceGroupController::class, 'index'])->name('sensor-device-groups.index');
Route::post('incidents', [IncidentController::class, 'store'])->name('incidents.store');
Route::get('incident-types', [IncidentTypeController::class, 'index'])->name('incident-types.index');
