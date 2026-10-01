<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorDashboardController;


/*
|--------------------------------------------------------------------------
| الصفحة الرئيسية
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->isDoctor()) {
        return redirect()->route('doctor.dashboard');
    }

    return redirect()->route('dashboard');

});


/*
|--------------------------------------------------------------------------
| لوحة التحكم الرئيسية
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,receptionist'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});


/*
|--------------------------------------------------------------------------
| الأقسام
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('departments', DepartmentController::class);

});


/*
|--------------------------------------------------------------------------
| الأطباء
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('doctors', DoctorController::class);

});


/*
|--------------------------------------------------------------------------
| المرضى
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,receptionist'])->group(function () {

    Route::resource('patients', PatientController::class);

});


/*
|--------------------------------------------------------------------------
| المواعيد
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,receptionist'])->group(function () {

    Route::resource('appointments', AppointmentController::class);

});


/*
|--------------------------------------------------------------------------
| لوحة الطبيب
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:doctor', 'doctor.profile'])->group(function () {

    Route::get(
        '/doctor/dashboard',
        [DoctorDashboardController::class, 'index']
    )->name('doctor.dashboard');


    Route::get(
        '/doctor/appointment/{id}',
        [DoctorDashboardController::class, 'appointment']
    )->name('doctor.appointment');


    Route::put(
        '/doctor/appointment/{id}',
        [DoctorDashboardController::class, 'updateAppointment']
    )->name('doctor.appointment.update');


    Route::get(
        '/doctor/appointment/{id}/print',
        [DoctorDashboardController::class, 'printPrescription']
    )->name('doctor.appointment.print');

});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
