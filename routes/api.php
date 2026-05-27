<?php

// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::prefix('appointments')->group(function () {
    Route::post('/',        [AppointmentController::class, 'book']);      // Book appointment
    Route::delete('/{id}',  [AppointmentController::class, 'cancel']);   // Cancel appointment
});
