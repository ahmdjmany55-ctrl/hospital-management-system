<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    /**
     * عرض قائمة الأطباء
     */
    public function index()
    {
        $doctors = Doctor::with('department')
            ->latest()
            ->paginate(10);

        return view('doctors.index', compact('doctors'));
    }

    /**
     * عرض صفحة إضافة طبيب
     */
    public function create()
    {
        $departments = Department::where('status', true)->get();

        return view('doctors.create', compact('departments'));
    }

    /**
     * حفظ طبيب جديد وإنشاء حساب دخول له
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
        ],

        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email',
            'unique:doctors,email',
        ],

        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
        ],

        'phone' => [
            'nullable',
            'string',
            'max:30',
        ],

        'specialization' => [
            'required',
            'string',
            'max:255',
        ],

        'department_id' => [
            'required',
            'exists:departments,id',
        ],

        'gender' => [
            'required',
            Rule::in(['male', 'female']),
        ],

        'status' => [
            'nullable',
            'boolean',
        ],
    ]);

    DB::transaction(function () use ($validated, $request) {

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'department_id' => $validated['department_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'specialization' => $validated['specialization'],
            'gender' => $validated['gender'],
            'status' => $request->boolean('status'),
        ]);
    });

    return redirect()
        ->route('doctors.index')
        ->with(
            'success',
            'تم إضافة الطبيب وإنشاء حساب الدخول الخاص به بنجاح.'
        );
}
    /**
     * عرض بيانات الطبيب
     */
    public function show(Doctor $doctor)
    {
        $doctor->load('department', 'user');

        return view('doctors.show', compact('doctor'));
    }

    /**
     * عرض صفحة تعديل الطبيب
     */
    public function edit(Doctor $doctor)
    {
        $departments = Department::where('status', true)->get();

        $doctor->load('user');

        return view('doctors.edit', compact('doctor', 'departments'));
    }

    /**
     * تحديث بيانات الطبيب وحساب الدخول
     */
    public function update(Request $request, Doctor $doctor)
    {
        $doctor->load('user');

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('doctors', 'email')->ignore($doctor->id),
                Rule::unique('users', 'email')->ignore($doctor->user_id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'specialization' => [
                'required',
                'string',
                'max:255',
            ],

            'department_id' => [
                'required',
                'exists:departments,id',
            ],

            'gender' => [
                'required',
                Rule::in(['male', 'female']),
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | تحديث حساب المستخدم
        |--------------------------------------------------------------------------
        */

        $doctor->user->name = $validated['name'];
        $doctor->user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $doctor->user->password = $validated['password'];
        }

        $doctor->user->save();

        /*
        |--------------------------------------------------------------------------
        | تحديث بيانات الطبيب
        |--------------------------------------------------------------------------
        */

        $doctor->update([
            'department_id' => $validated['department_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'specialization' => $validated['specialization'],
            'gender' => $validated['gender'],
            'status' => $request->boolean('status'),
        ]);

        return redirect()
            ->route('doctors.index')
            ->with(
                'success',
                'تم تحديث بيانات الطبيب بنجاح.'
            );
    }

    /**
     * حذف الطبيب وحساب الدخول المرتبط به
     */
    public function destroy(Doctor $doctor)
    {
        $user = $doctor->user;

        $doctor->delete();

        if ($user) {
            $user->delete();
        }

        return redirect()
            ->route('doctors.index')
            ->with(
                'success',
                'تم حذف الطبيب وحساب الدخول الخاص به بنجاح.'
            );
    }
}
