<?php

use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\IncidentTypeController;
use App\Http\Controllers\Api\MapPinController;
use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\Api\SensorDeviceGroupController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Dashboard\AlertController as DashboardAlertController;
use App\Http\Controllers\Api\Dashboard\IncidentController as DashboardIncidentController;
use App\Http\Controllers\Api\Dashboard\MapPinController as DashboardMapPinController;
use App\Http\Controllers\Api\Dashboard\SensorDeviceGroupController as DashboardSensorDeviceGroupController;
use Illuminate\Support\Facades\Route;


Route::prefix('dashboard')->name('dashboard.')->group(function () {

    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('token', [AuthController::class, 'createToken'])->name('create-token');
        // Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
        // Route::post('verify-reset-code', [AuthController::class, 'verifyResetCode'])->name('verify-reset-code');
        // Route::post('reset-password-with-token', [AuthController::class, 'resetPasswordWithToken'])->name('reset-password-with-token');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('incidents', [DashboardIncidentController::class, 'index'])->name('incidents.index');
        Route::get('alerts', [DashboardAlertController::class, 'index'])->name('alerts.index');
        Route::post('alerts', [DashboardAlertController::class, 'store'])->name('alerts.store');
        Route::get('map-pins', [DashboardMapPinController::class, 'index'])->name('map-pins.index');
        Route::post('map-pins', [DashboardMapPinController::class, 'store'])->name('map-pins.store');
        Route::put('map-pins/{mapPin}', [DashboardMapPinController::class, 'update'])->name('map-pins.update');
        Route::delete('map-pins/{mapPin}', [DashboardMapPinController::class, 'destroy'])->name('map-pins.destroy');
        Route::get('sensor-device-groups', [DashboardSensorDeviceGroupController::class, 'index'])->name('sensor-device-groups.index');
    });

});


Route::get('alerts', [AlertController::class, 'index'])->name('alerts.index');
Route::get('map-pins', [MapPinController::class, 'index'])->name('map-pins.index');
Route::get('sensor-device-groups', [SensorDeviceGroupController::class, 'index'])->name('sensor-device-groups.index');
Route::post('incidents', [IncidentController::class, 'store'])->name('incidents.store');
Route::get('incident-types', [IncidentTypeController::class, 'index'])->name('incident-types.index');
