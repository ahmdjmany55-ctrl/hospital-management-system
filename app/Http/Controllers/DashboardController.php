<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $departmentsCount = Department::count();

        $doctorsCount = Doctor::count();

        $patientsCount = Patient::count();

        $appointmentsCount = Appointment::count();

        $todayAppointmentsCount = Appointment::whereDate(
            'appointment_date',
            Carbon::today()
        )->count();

        $scheduledAppointmentsCount = Appointment::where(
            'status',
            'scheduled'
        )->count();

        $completedAppointmentsCount = Appointment::where(
            'status',
            'completed'
        )->count();

        $cancelledAppointmentsCount = Appointment::where(
            'status',
            'cancelled'
        )->count();

        $todayAppointments = Appointment::with([
            'patient',
            'doctor'
        ])
        ->whereDate(
            'appointment_date',
            Carbon::today()
        )
        ->orderBy('appointment_time')
        ->get();

        return view('dashboard', compact(
            'departmentsCount',
            'doctorsCount',
            'patientsCount',
            'appointmentsCount',
            'todayAppointmentsCount',
            'scheduledAppointmentsCount',
            'completedAppointmentsCount',
            'cancelledAppointmentsCount',
            'todayAppointments'
        ));
    }
}
