@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>إضافة موعد جديد</h2>

    <a href="/appointments" class="btn btn-secondary">
        العودة إلى المواعيد
    </a>

</div>


<form action="/appointments" method="POST">

    @csrf


    {{-- المريض --}}
    <div class="mb-3">

        <label class="form-label">
            المريض
        </label>

        <select
            name="patient_id"
            class="form-select"
            required
        >

            <option value="">
                -- اختر المريض --
            </option>

            @foreach($patients as $patient)

                <option
                    value="{{ $patient->id }}"
                    {{ old('patient_id') == $patient->id ? 'selected' : '' }}
                >
                    {{ $patient->name }}
                </option>

            @endforeach

        </select>

        @error('patient_id')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- الطبيب --}}
    <div class="mb-3">

        <label class="form-label">
            الطبيب
        </label>

        <select
            name="doctor_id"
            class="form-select"
            required
        >

            <option value="">
                -- اختر الطبيب --
            </option>

            @foreach($doctors as $doctor)

                <option
                    value="{{ $doctor->id }}"
                    {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}
                >
                    د. {{ $doctor->name }}
                    - {{ $doctor->specialization }}
                </option>

            @endforeach

        </select>

        @error('doctor_id')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- التاريخ --}}
    <div class="mb-3">

        <label class="form-label">
            تاريخ الموعد
        </label>

        <input
            type="date"
            name="appointment_date"
            class="form-control"
            value="{{ old('appointment_date') }}"
            required
        >

        @error('appointment_date')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- الوقت --}}
    <div class="mb-3">

        <label class="form-label">
            وقت الموعد
        </label>

        <input
            type="time"
            name="appointment_time"
            class="form-control"
            value="{{ old('appointment_time') }}"
            required
        >

        @error('appointment_time')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- الحالة --}}
    <div class="mb-3">

        <label class="form-label">
            حالة الموعد
        </label>

        <select
            name="status"
            class="form-select"
            required
        >

            <option
                value="scheduled"
                {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}
            >
                مجدول
            </option>

            <option
                value="completed"
                {{ old('status') == 'completed' ? 'selected' : '' }}
            >
                مكتمل
            </option>

            <option
                value="cancelled"
                {{ old('status') == 'cancelled' ? 'selected' : '' }}
            >
                ملغي
            </option>

        </select>

        @error('status')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- الملاحظات --}}
    <div class="mb-4">

        <label class="form-label">
            ملاحظات
        </label>

        <textarea
            name="notes"
            class="form-control"
            rows="4"
            placeholder="أدخل ملاحظات الموعد إن وجدت"
        >{{ old('notes') }}</textarea>

        @error('notes')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    <button
        type="submit"
        class="btn btn-primary"
    >
        حفظ الموعد
    </button>


    <a
        href="/appointments"
        class="btn btn-secondary"
    >
        إلغاء
    </a>

</form>

@endsection
