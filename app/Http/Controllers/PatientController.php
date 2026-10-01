<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Department;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('department')->get();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        $departments = Department::where('status', true)->get();

        return view('patients.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:255',

            'phone' => 'nullable|max:20',

            'email' => 'nullable|email|max:255',

            'date_of_birth' => 'nullable|date',

            'gender' => 'required|in:male,female',

            'address' => 'nullable',

            'department_id' => 'nullable|exists:departments,id',

            'medical_history' => 'nullable',

            'status' => 'required|boolean',

        ]);

        Patient::create([

            'name' => $request->name,

            'phone' => $request->phone,

            'email' => $request->email,

            'date_of_birth' => $request->date_of_birth,

            'gender' => $request->gender,

            'address' => $request->address,

            'department_id' => $request->department_id,

            'medical_history' => $request->medical_history,

            'status' => $request->status,

        ]);

        return redirect('/patients')
            ->with('success', 'تم إضافة المريض بنجاح');
    }

    public function edit(Patient $patient)
    {
        $departments = Department::where('status', true)->get();

        return view('patients.edit', compact('patient', 'departments'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([

            'name' => 'required|max:255',

            'phone' => 'nullable|max:20',

            'email' => 'nullable|email|max:255',

            'date_of_birth' => 'nullable|date',

            'gender' => 'required|in:male,female',

            'address' => 'nullable',

            'department_id' => 'nullable|exists:departments,id',

            'medical_history' => 'nullable',

            'status' => 'required|boolean',

        ]);

        $patient->update([

            'name' => $request->name,

            'phone' => $request->phone,

            'email' => $request->email,

            'date_of_birth' => $request->date_of_birth,

            'gender' => $request->gender,

            'address' => $request->address,

            'department_id' => $request->department_id,

            'medical_history' => $request->medical_history,

            'status' => $request->status,

        ]);

        return redirect('/patients')
            ->with('success', 'تم تحديث بيانات المريض بنجاح');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect('/patients')
            ->with('success', 'تم حذف المريض بنجاح');
    }
}
