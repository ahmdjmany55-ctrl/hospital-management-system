@extends('layouts.app')

@section('content')

{{-- ====================== الترحيب ====================== --}}
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1">
            مرحبًا د. {{ $doctor->name }} 👋
        </h2>
        <p class="text-muted mb-0">
            لوحة التحكم — {{ now()->translatedFormat('l، j F Y') }}
        </p>
    </div>
    <div class="text-muted small">
        <i class="bi bi-clock"></i> آخر تحديث: {{ now()->format('h:i A') }}
    </div>
</div>


{{-- ====================== البطاقات الإحصائية ====================== --}}
<div class="row g-3 mb-4">

    <div class="col-md-6 col-lg-3">
        <div class="card stat-card stat-primary border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1">جميع المواعيد</h6>
                    <h2 class="fw-bold mb-0">{{ $appointmentsCount }}</h2>
                </div>
                <div class="stat-icon"><i class="bi bi-calendar2-week"></i></div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card stat-card stat-success border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1">مواعيد اليوم</h6>
                    <h2 class="fw-bold mb-0">{{ $todayAppointmentsCount }}</h2>
                </div>
                <div class="stat-icon"><i class="bi bi-calendar-day"></i></div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card stat-card stat-warning border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1">المواعيد القادمة</h6>
                    <h2 class="fw-bold mb-0">{{ $scheduledAppointmentsCount }}</h2>
                </div>
                <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card stat-card stat-info border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1">المواعيد المكتملة</h6>
                    <h2 class="fw-bold mb-0">{{ $completedAppointmentsCount }}</h2>
                </div>
                <div class="stat-icon"><i class="bi bi-check2-circle"></i></div>
            </div>
        </div>
    </div>

</div>


{{-- ====================== شريط البحث والفلترة ====================== --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('doctor.dashboard') }}" class="row g-2 align-items-end">

            {{-- البحث --}}
            <div class="col-md-4">
                <label class="form-label small fw-semibold mb-1">
                    <i class="bi bi-search"></i> بحث
                </label>
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="اسم المريض أو رقم الهاتف..."
                       value="{{ $search }}">
            </div>

            {{-- الفترة --}}
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">
                    <i class="bi bi-calendar-range"></i> الفترة
                </label>
                <select name="period" class="form-select">
                    <option value="upcoming" @selected($period === 'upcoming')>القادمة (افتراضي)</option>
                    <option value="today" @selected($period === 'today')>اليوم</option>
                    <option value="week" @selected($period === 'week')>هذا الأسبوع</option>
                    <option value="month" @selected($period === 'month')>هذا الشهر</option>
                    <option value="past" @selected($period === 'past')>السابقة</option>
                    <option value="all" @selected($period === 'all')>الكل</option>
                </select>
            </div>

            {{-- الحالة --}}
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">
                    <i class="bi bi-flag"></i> الحالة
                </label>
                <select name="status" class="form-select">
                    <option value="">كل الحالات</option>
                    <option value="scheduled" @selected($status === 'scheduled')>مجدول</option>
                    <option value="completed" @selected($status === 'completed')>مكتمل</option>
                    <option value="cancelled" @selected($status === 'cancelled')>ملغي</option>
                </select>
            </div>

            {{-- أزرار --}}
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel"></i> تطبيق
                </button>
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-secondary" title="إعادة تعيين">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>

        </form>
    </div>
</div>


{{-- ====================== نتائج البحث ====================== --}}
@if($search || $status || $period !== 'upcoming')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-funnel-fill text-primary me-2"></i>
            نتائج البحث
        </h5>
        <span class="badge bg-primary-subtle text-primary-emphasis">
            @if($appointments->total() === 0)
                لا توجد نتائج
            @elseif($appointments->total() === 1)
                نتيجة واحدة
            @elseif($appointments->total() === 2)
                نتيجتان
            @else
                {{ $appointments->total() }} نتيجة
            @endif
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">المريض</th>
                        <th>التاريخ</th>
                        <th>الوقت</th>
                        <th>الحالة</th>
                        <th class="text-end pe-4">الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $appointment->patient->name ?? 'غير محدد' }}</div>
                                        <small class="text-muted">
                                            <i class="bi bi-telephone"></i> {{ $appointment->patient->phone ?? '-' }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->translatedFormat('j F Y') }}
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-clock"></i>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </span>
                            </td>
                            <td>
                                @if($appointment->status === 'scheduled')
                                    <span class="badge bg-primary-subtle text-primary-emphasis">
                                        <i class="bi bi-clock-history"></i> مجدول
                                    </span>
                                @elseif($appointment->status === 'completed')
                                    <span class="badge bg-success-subtle text-success-emphasis">
                                        <i class="bi bi-check2-circle"></i> مكتمل
                                    </span>
                                @elseif($appointment->status === 'cancelled')
                                    <span class="badge bg-danger-subtle text-danger-emphasis">
                                        <i class="bi bi-x-circle"></i> ملغي
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('doctor.appointment', $appointment->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> عرض
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="bi bi-search"></i></div>
                                    <h6 class="fw-bold mt-3 mb-1">لا توجد نتائج</h6>
                                    <p class="text-muted mb-0 small">جرب تغيير معايير البحث</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($appointments->hasPages())
        <div class="card-footer bg-white">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endif


{{-- ====================== مواعيد اليوم ====================== --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-calendar-check text-success me-2"></i>
            مواعيد اليوم
        </h5>
        <span class="badge bg-success-subtle text-success-emphasis">
            @if($todayAppointments->total() === 0)
                لا توجد مواعيد
            @elseif($todayAppointments->total() === 1)
                موعد واحد
            @elseif($todayAppointments->total() === 2)
                موعدان
            @else
                {{ $todayAppointments->total() }} مواعيد
            @endif
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">المريض</th>
                        <th>الوقت</th>
                        <th>الحالة</th>
                        <th class="text-end pe-4">الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todayAppointments as $appointment)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $appointment->patient->name ?? 'غير محدد' }}</div>
                                        <small class="text-muted">
                                            <i class="bi bi-telephone"></i> {{ $appointment->patient->phone ?? '-' }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-clock"></i>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </span>
                            </td>
                            <td>
                                @if($appointment->status === 'scheduled')
                                    <span class="badge bg-primary-subtle text-primary-emphasis">
                                        <i class="bi bi-clock-history"></i> مجدول
                                    </span>
                                @elseif($appointment->status === 'completed')
                                    <span class="badge bg-success-subtle text-success-emphasis">
                                        <i class="bi bi-check2-circle"></i> مكتمل
                                    </span>
                                @elseif($appointment->status === 'cancelled')
                                    <span class="badge bg-danger-subtle text-danger-emphasis">
                                        <i class="bi bi-x-circle"></i> ملغي
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('doctor.appointment', $appointment->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> عرض
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="bi bi-cup-hot"></i></div>
                                    <h6 class="fw-bold mt-3 mb-1">لا توجد مواعيد اليوم</h6>
                                    <p class="text-muted mb-0 small">استمتع بيومك! ☕</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($todayAppointments->hasPages())
        <div class="card-footer bg-white">
            {{ $todayAppointments->links() }}
        </div>
    @endif
</div>


{{-- ====================== المواعيد القادمة ====================== --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-calendar-event text-warning me-2"></i>
            المواعيد القادمة
        </h5>
        <span class="badge bg-warning-subtle text-warning-emphasis">
            @if($upcomingAppointments->total() === 0)
                لا توجد مواعيد
            @elseif($upcomingAppointments->total() === 1)
                موعد واحد
            @elseif($upcomingAppointments->total() === 2)
                موعدان
            @else
                {{ $upcomingAppointments->total() }} مواعيد
            @endif
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">المريض</th>
                        <th>التاريخ</th>
                        <th>الوقت</th>
                        <th>بعد</th>
                        <th class="text-end pe-4">الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($upcomingAppointments as $appointment)
                        @php $date = \Carbon\Carbon::parse($appointment->appointment_date); @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div class="fw-semibold">{{ $appointment->patient->name ?? 'غير محدد' }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $date->translatedFormat('j F Y') }}</span>
                                <br>
                                <small class="text-muted">{{ $date->translatedFormat('l') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-clock"></i>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $date->diffForHumans() }}</small>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('doctor.appointment', $appointment->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> عرض
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="bi bi-calendar-x"></i></div>
                                    <h6 class="fw-bold mt-3 mb-1">لا توجد مواعيد قادمة</h6>
                                    <p class="text-muted mb-0 small">سيظهر هنا أي موعد جديد</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($upcomingAppointments->hasPages())
        <div class="card-footer bg-white">
            {{ $upcomingAppointments->links() }}
        </div>
    @endif
</div>


@push('styles')
<style>
    .stat-card {
        border-radius: 14px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
    }
    .stat-card .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .stat-primary .stat-icon { background: #e7f1ff; color: #0d6efd; }
    .stat-success .stat-icon { background: #d1e7dd; color: #198754; }
    .stat-warning .stat-icon { background: #fff3cd; color: #ffc107; }
    .stat-info .stat-icon { background: #d1e7dd; color: #198754; }

    .avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .empty-state { text-align: center; padding: 1rem; }
    .empty-icon { font-size: 3rem; line-height: 1; color: #adb5bd; }

    .table > :not(caption) > * > * { padding: 0.9rem 0.75rem; }
    .badge { font-weight: 500; padding: 0.4em 0.7em; }
</style>
@endpush

@endsection
