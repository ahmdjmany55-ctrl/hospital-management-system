<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with([
            'patient',
            'doctor'
        ])
        ->orderBy('appointment_date')
        ->orderBy('appointment_time')
        ->get();

        return view('appointments.index', compact('appointments'));
    }


    public function create()
    {
        $patients = Patient::where('status', true)
            ->orderBy('name')
            ->get();

        $doctors = Doctor::where('status', true)
            ->orderBy('name')
            ->get();

        return view('appointments.create', compact(
            'patients',
            'doctors'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([

            'patient_id' => 'required|exists:patients,id',

            'doctor_id' => 'required|exists:doctors,id',

            'appointment_date' => 'required|date',

            'appointment_time' => 'required',

            'status' => 'required|in:scheduled,completed,cancelled',

            'notes' => 'nullable',

        ]);


        /*
        |--------------------------------------------------------------------------
        | منع حجز الطبيب مرتين في نفس التاريخ والوقت
        |--------------------------------------------------------------------------
        */

        $appointmentExists = Appointment::where(
            'doctor_id',
            $request->doctor_id
        )
        ->where(
            'appointment_date',
            $request->appointment_date
        )
        ->where(
            'appointment_time',
            $request->appointment_time
        )
        ->whereIn('status', [
            'scheduled',
            'completed'
        ])
        ->exists();


        if ($appointmentExists) {

            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' =>
                    'هذا الطبيب لديه موعد آخر في نفس التاريخ والوقت.'
                ]);
        }


        Appointment::create([

            'patient_id' => $request->patient_id,

            'doctor_id' => $request->doctor_id,

            'appointment_date' => $request->appointment_date,

            'appointment_time' => $request->appointment_time,

            'status' => $request->status,

            'notes' => $request->notes,

        ]);


        return redirect('/appointments')
            ->with('success', 'تم إضافة الموعد بنجاح');
    }


    public function edit(Appointment $appointment)
    {
        $patients = Patient::where('status', true)
            ->orderBy('name')
            ->get();

        $doctors = Doctor::where('status', true)
            ->orderBy('name')
            ->get();

        return view('appointments.edit', compact(
            'appointment',
            'patients',
            'doctors'
        ));
    }


    public function update(
        Request $request,
        Appointment $appointment
    ) {
        $request->validate([

            'patient_id' => 'required|exists:patients,id',

            'doctor_id' => 'required|exists:doctors,id',

            'appointment_date' => 'required|date',

            'appointment_time' => 'required',

            'status' => 'required|in:scheduled,completed,cancelled',

            'notes' => 'nullable',

        ]);


        /*
        |--------------------------------------------------------------------------
        | منع تعارض الموعد عند التعديل
        |--------------------------------------------------------------------------
        */

        $appointmentExists = Appointment::where(
            'doctor_id',
            $request->doctor_id
        )
        ->where(
            'appointment_date',
            $request->appointment_date
        )
        ->where(
            'appointment_time',
            $request->appointment_time
        )
        ->whereIn('status', [
            'scheduled',
            'completed'
        ])
        ->where(
            'id',
            '!=',
            $appointment->id
        )
        ->exists();


        if ($appointmentExists) {

            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' =>
                    'هذا الطبيب لديه موعد آخر في نفس التاريخ والوقت.'
                ]);
        }


        $appointment->update([

            'patient_id' => $request->patient_id,

            'doctor_id' => $request->doctor_id,

            'appointment_date' => $request->appointment_date,

            'appointment_time' => $request->appointment_time,

            'status' => $request->status,

            'notes' => $request->notes,

        ]);


        return redirect('/appointments')
            ->with('success', 'تم تحديث الموعد بنجاح');
    }


    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect('/appointments')
            ->with('success', 'تم حذف الموعد بنجاح');
    }
}
