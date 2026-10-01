<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorDashboardController extends Controller
{
    /**
     * لوحة الطبيب الرئيسية مع البحث والفلترة
     */
    public function index(Request $request)
    {
        $doctor = auth()->user()->doctor;

        // =========================
        // الإحصائيات
        // =========================
        $appointmentsCount = Appointment::where('doctor_id', $doctor->id)->count();

        $todayAppointmentsCount = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', Carbon::today())
            ->count();

        $scheduledAppointmentsCount = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'scheduled')
            ->whereDate('appointment_date', '>=', Carbon::today())
            ->count();

        $completedAppointmentsCount = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->count();

        // =========================
        // البحث والفلترة
        // =========================
        $search = $request->get('search');
        $status = $request->get('status');
        $period = $request->get('period', 'upcoming'); // today / week / month / all / upcoming

        // استعلام موحّد
        $query = Appointment::with('patient')
            ->where('doctor_id', $doctor->id);

        // بحث
        if ($search) {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // فلترة بالحالة
        if ($status) {
            $query->where('status', $status);
        }

        // فلترة بالفترة
        switch ($period) {
            case 'today':
                $query->whereDate('appointment_date', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('appointment_date', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ]);
                break;
            case 'month':
                $query->whereMonth('appointment_date', Carbon::now()->month)
                      ->whereYear('appointment_date', Carbon::now()->year);
                break;
            case 'past':
                $query->whereDate('appointment_date', '<', Carbon::today());
                break;
            case 'all':
                // بدون فلتر
                break;
            case 'upcoming':
            default:
                $query->whereDate('appointment_date', '>=', Carbon::today());
                break;
        }

        // الترتيب
        $query->orderBy('appointment_date', 'desc')
              ->orderBy('appointment_time', 'desc');

        $appointments = $query->paginate(15)->withQueryString();

        // =========================
        // مواعيد اليوم والقادمة (للواجهة العلوية)
        // =========================
        $todayAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', Carbon::today())
            ->orderBy('appointment_time')
            ->paginate(15, ['*'], 'today_page');

        $upcomingAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', '>', Carbon::today())
            ->where('status', 'scheduled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(10, ['*'], 'upcoming_page');

        return view('doctor.dashboard', compact(
            'doctor',
            'appointmentsCount',
            'todayAppointmentsCount',
            'scheduledAppointmentsCount',
            'completedAppointmentsCount',
            'todayAppointments',
            'upcomingAppointments',
            'appointments',
            'search',
            'status',
            'period'
        ));
    }

    /**
     * عرض تفاصيل موعد واحد
     */
    public function appointment($id)
    {
        $doctor = auth()->user()->doctor;

        $appointment = Appointment::with(['patient.department'])
            ->where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        $patientHistory = Appointment::where('patient_id', $appointment->patient_id)
            ->where('id', '!=', $appointment->id)
            ->where(function ($query) {
                $query->whereNotNull('diagnosis')
                      ->orWhereNotNull('prescription');
            })
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();

        return view('doctor.appointment', compact('appointment', 'patientHistory'));
    }

    /**
     * تحديث بيانات موعد
     */
    public function updateAppointment(Request $request, $id)
    {
        $doctor = auth()->user()->doctor;

        $appointment = Appointment::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        if ($appointment->status === 'cancelled') {
            return back()->with('error', 'لا يمكن تعديل موعد ملغى.');
        }

        $validated = $request->validate([
            'diagnosis' => ['nullable', 'string', 'max:5000'],
            'medical_notes' => ['nullable', 'string', 'max:5000'],
            'prescription' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'in:scheduled,completed,cancelled'],
        ]);

        $appointment->update($validated);

        return redirect()
            ->route('doctor.appointment', $appointment->id)
            ->with('success', 'تم حفظ بيانات الموعد بنجاح.');
    }

    /**
     * طباعة الوصفة الطبية
     */
    public function printPrescription($id)
    {
        $doctor = auth()->user()->doctor;

        $appointment = Appointment::with(['patient', 'doctor.department'])
            ->where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        return view('doctor.print-prescription', compact('appointment'));
    }
}
