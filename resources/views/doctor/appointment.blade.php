@extends('layouts.app')

@section('content')

{{-- ====================== الترويسة ====================== --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-clipboard2-pulse text-primary"></i>
            تفاصيل الموعد
        </h2>
        <p class="text-muted mb-0">
            #{{ $appointment->id }} — {{ \Carbon\Carbon::parse($appointment->appointment_date)->translatedFormat('l، j F Y') }}
        </p>
    </div>
    <div>
        <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right"></i> رجوع
        </a>
        @if($appointment->diagnosis || $appointment->prescription)
            <a href="{{ route('doctor.appointment.print', $appointment->id) }}"
               target="_blank"
               class="btn btn-outline-primary">
                <i class="bi bi-printer"></i> طباعة الوصفة
            </a>
        @endif
    </div>
</div>


{{-- ====================== بيانات المريض ====================== --}}
<div class="row g-4 mb-4">

    {{-- معلومات المريض --}}
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-person-vcard text-primary me-2"></i>
                    بيانات المريض
                </h5>
            </div>
            <div class="card-body">

                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <div class="avatar-lg me-3">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">
                            {{ $appointment->patient->name ?? 'غير محدد' }}
                        </h5>
                        <span class="text-muted">
                            @if($appointment->patient && $appointment->patient->gender === 'male')
                                <i class="bi bi-gender-male"></i> ذكر
                            @elseif($appointment->patient && $appointment->patient->gender === 'female')
                                <i class="bi bi-gender-female"></i> أنثى
                            @endif
                        </span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <small class="text-muted d-block">الهاتف</small>
                        <strong>
                            <i class="bi bi-telephone text-muted"></i>
                            {{ $appointment->patient->phone ?? '-' }}
                        </strong>
                    </div>

                    <div class="col-6">
                        <small class="text-muted d-block">البريد الإلكتروني</small>
                        <strong>
                            {{ $appointment->patient->email ?? '-' }}
                        </strong>
                    </div>

                    <div class="col-6">
                        <small class="text-muted d-block">العمر</small>
                        <strong>
                            @if($appointment->patient->date_of_birth)
                                {{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age }} سنة
                            @else
                                -
                            @endif
                        </strong>
                    </div>

                    <div class="col-6">
                        <small class="text-muted d-block">القسم</small>
                        <strong>
                            {{ $appointment->patient->department->name ?? '-' }}
                        </strong>
                    </div>

                    @if($appointment->patient->address)
                    <div class="col-12">
                        <small class="text-muted d-block">العنوان</small>
                        <strong>{{ $appointment->patient->address }}</strong>
                    </div>
                    @endif
                </div>

                @if($appointment->patient->medical_history)
                    <div class="alert alert-warning mt-3 mb-0 small">
                        <strong><i class="bi bi-exclamation-triangle"></i> السجل الطبي:</strong>
                        <p class="mb-0 mt-1">{{ $appointment->patient->medical_history }}</p>
                    </div>
                @endif

            </div>
        </div>
    </div>


    {{-- تفاصيل الموعد --}}
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-calendar-check text-primary me-2"></i>
                    تفاصيل الموعد
                </h5>
            </div>
            <div class="card-body">

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="info-box">
                            <small class="text-muted d-block">التاريخ</small>
                            <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->translatedFormat('j F Y') }}</strong>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <small class="text-muted d-block">الوقت</small>
                            <strong>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</strong>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <small class="text-muted d-block">الحالة</small>
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
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <small class="text-muted d-block">الطبيب</small>
                            <strong>د. {{ $appointment->doctor->name ?? auth()->user()->name }}</strong>
                        </div>
                    </div>
                </div>

                @if($appointment->notes)
                    <div class="alert alert-light border mb-0">
                        <small class="text-muted d-block mb-1">ملاحظات الاستقبال:</small>
                        {{ $appointment->notes }}
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>


{{-- ====================== السجل الطبي السابق ====================== --}}
@if($patientHistory->count() > 0)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-clock-history text-info me-2"></i>
                الزيارات السابقة
            </h5>
            <span class="badge bg-info-subtle text-info-emphasis">
                آخر {{ $patientHistory->count() }} زيارة
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">التاريخ</th>
                            <th>التشخيص</th>
                            <th>الوصفة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patientHistory as $history)
                            <tr>
                                <td class="ps-4">
                                    <small class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($history->appointment_date)->translatedFormat('j F Y') }}
                                    </small>
                                </td>
                                <td>
                                    <small>{{ Str::limit($history->diagnosis, 60) ?: '-' }}</small>
                                </td>
                                <td>
                                    <small>{{ Str::limit($history->prescription, 60) ?: '-' }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif


{{-- ====================== نموذج البيانات الطبية ====================== --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-clipboard2-plus text-success me-2"></i>
            البيانات الطبية
        </h5>
    </div>
    <div class="card-body">

        @if($appointment->status === 'cancelled')
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i>
                هذا الموعد ملغي — لا يمكن تعديل بياناته.
            </div>
        @else

        <form method="POST" action="{{ route('doctor.appointment.update', $appointment->id) }}">
            @csrf
            @method('PUT')

            {{-- التشخيص --}}
            <div class="mb-3">
                <label for="diagnosis" class="form-label fw-semibold">
                    <i class="bi bi-stethoscope text-primary"></i> التشخيص
                </label>
                <textarea id="diagnosis"
                          name="diagnosis"
                          class="form-control @error('diagnosis') is-invalid @enderror"
                          rows="4"
                          placeholder="اكتب تشخيص حالة المريض..."
                >{{ old('diagnosis', $appointment->diagnosis) }}</textarea>
                @error('diagnosis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- الملاحظات --}}
            <div class="mb-3">
                <label for="medical_notes" class="form-label fw-semibold">
                    <i class="bi bi-journal-text text-info"></i> الملاحظات الطبية
                </label>
                <textarea id="medical_notes"
                          name="medical_notes"
                          class="form-control @error('medical_notes') is-invalid @enderror"
                          rows="3"
                          placeholder="اكتب الملاحظات الطبية..."
                >{{ old('medical_notes', $appointment->medical_notes) }}</textarea>
                @error('medical_notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- الوصفة --}}
            <div class="mb-3">
                <label for="prescription" class="form-label fw-semibold">
                    <i class="bi bi-prescription2 text-success"></i> الوصفة / العلاج
                </label>
                <textarea id="prescription"
                          name="prescription"
                          class="form-control @error('prescription') is-invalid @enderror"
                          rows="5"
                          placeholder="مثال:&#10;1. Panadol 500mg - قرص كل 8 ساعات&#10;2. Augmentin 1g - قرص كل 12 ساعة لمدة 7 أيام"
                >{{ old('prescription', $appointment->prescription) }}</textarea>
                @error('prescription')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- الحالة --}}
            <div class="mb-4">
                <label for="status" class="form-label fw-semibold">
                    <i class="bi bi-flag text-warning"></i> حالة الموعد
                </label>
                <select id="status"
                        name="status"
                        class="form-select @error('status') is-invalid @enderror">
                    <option value="scheduled" @selected(old('status', $appointment->status) === 'scheduled')>
                        ⏳ مجدول
                    </option>
                    <option value="completed" @selected(old('status', $appointment->status) === 'completed')>
                        ✅ مكتمل
                    </option>
                    <option value="cancelled" @selected(old('status', $appointment->status) === 'cancelled')>
                        ❌ ملغي
                    </option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-light">
                    إلغاء
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> حفظ البيانات
                </button>
            </div>

        </form>

        @endif

    </div>
</div>


@push('styles')
<style>
    .avatar-lg {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .info-box {
        background: #f8f9fa;
        padding: 0.75rem 1rem;
        border-radius: 8px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    textarea {
        resize: vertical;
        min-height: 80px;
    }
</style>
@endpush

@endsection
