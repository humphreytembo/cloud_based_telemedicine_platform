<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DrAIController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ConsultationReportController;
use App\Http\Controllers\HealthLearnController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/login',    [AuthController::class, 'showlogin'])->name('showlogin');
Route::get('/register', [AuthController::class, 'showregister'])->name('showregister');
Route::post('/login',   [AuthController::class, 'login'])->name('login');
Route::post('/register',[AuthController::class, 'register'])->name('register');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

// Admin
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard',          [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/doctors/pending',    [AdminController::class, 'pendingDoctors'])->name('admin.doctors.pending');
    Route::get('/doctors/approved',   [AdminController::class, 'approvedDoctors'])->name('admin.doctors.approved');
    Route::get('/patients',           [AdminController::class, 'patients'])->name('admin.patients');
    Route::get('/appointments',       [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::post('/doctor/{id}/approve',[AdminController::class, 'approve'])->name('approve.doctor');
    Route::post('/doctor/{id}/reject', [AdminController::class, 'reject'])->name('reject.doctor');
    Route::delete('/doctors/{id}/delete',[AdminController::class, 'deleteDoctor'])->name('admin.doctors.delete');
    Route::delete('/patients/{id}/delete',[AdminController::class, 'deletePatient'])->name('admin.patients.delete');
});

// Doctor
Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/dashboard', [AppointmentController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/messages',  [ChatController::class, 'doctorInbox'])->name('doctor.messages');
});

// Appointments
Route::middleware(['auth'])->group(function () {
    Route::get('/appointments/book',           [AppointmentController::class, 'create']);
    Route::post('/appointments/book',          [AppointmentController::class, 'store']);
    Route::get('/appointments',                [AppointmentController::class, 'index']);
    Route::post('/appointment/{id}/approve',   [AppointmentController::class, 'approve'])->name('appointment.approve');
    Route::post('/appointment/{id}/reject',    [AppointmentController::class, 'reject'])->name('appointment.reject');
    Route::post('/appointment/reschedule/{id}',[AppointmentController::class, 'reschedule'])->name('appointment.reschedule');
});

// Chat
Route::middleware(['auth'])->group(function () {
    Route::get('/doctors/consult', [DoctorController::class, 'consult']);
    Route::get('/chat/{doctor}',   [ChatController::class, 'index'])->name('chat.show'); // ✅ named
});

Route::post('/chat/send', [ChatController::class, 'send'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::post('/chat/call', [ChatController::class, 'initiateCall'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::post('/chat/signal', [ChatController::class, 'signal'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Dr AI
Route::view('/dr-ai-chat', 'dr-ai');
Route::post('/dr-ai', [DrAIController::class, 'ask']);

// Password Reset
Route::get('/forgot-password',       [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password',      [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}',[ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password',       [ResetPasswordController::class, 'reset'])->name('password.update');

// Consultation Reports
Route::middleware(['auth'])->group(function () {
    Route::get('/reports',                                    [ConsultationReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{id}',                               [ConsultationReportController::class, 'show'])->name('reports.show');
    Route::get('/appointments/{appointmentId}/report/create', [ConsultationReportController::class, 'create'])->name('reports.create');
    Route::post('/appointments/{appointmentId}/report',       [ConsultationReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{id}/edit',                          [ConsultationReportController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{id}',                               [ConsultationReportController::class, 'update'])->name('reports.update');
    Route::post('/reports/{id}/vitals',                       [ConsultationReportController::class, 'updateVitals'])->name('reports.vitals');
    Route::get('/reports/{id}/pdf',                           [ConsultationReportController::class, 'downloadPdf'])->name('reports.pdf');
});

Broadcast::routes(['middleware' => ['auth']]);

// Health Learning Centre
Route::middleware(['auth'])->group(function () {
    Route::get('/health-learn',        [HealthLearnController::class, 'index'])->name('health.learn');
    Route::get('/health-learn/{slug}', [HealthLearnController::class, 'show'])->name('health.learn.article'); // ✅ fixed case
});