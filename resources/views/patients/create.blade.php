@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>إضافة مريض جديد</h2>

    <a href="/patients" class="btn btn-secondary">
        العودة إلى المرضى
    </a>

</div>

<form action="/patients" method="POST">

    @csrf


    {{-- اسم المريض --}}
    <div class="mb-3">

        <label class="form-label">
            اسم المريض
        </label>

        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name') }}"
            required
        >

        @error('name')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- رقم الهاتف --}}
    <div class="mb-3">

        <label class="form-label">
            رقم الهاتف
        </label>

        <input
            type="text"
            name="phone"
            class="form-control"
            value="{{ old('phone') }}"
        >

        @error('phone')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- البريد الإلكتروني --}}
    <div class="mb-3">

        <label class="form-label">
            البريد الإلكتروني
        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email') }}"
        >

        @error('email')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- تاريخ الميلاد --}}
    <div class="mb-3">

        <label class="form-label">
            تاريخ الميلاد
        </label>

        <input
            type="date"
            name="date_of_birth"
            class="form-control"
            value="{{ old('date_of_birth') }}"
        >

        @error('date_of_birth')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- الجنس --}}
    <div class="mb-3">

        <label class="form-label">
            الجنس
        </label>

        <select
            name="gender"
            class="form-select"
            required
        >

            <option value="">
                -- اختر الجنس --
            </option>

            <option
                value="male"
                {{ old('gender') == 'male' ? 'selected' : '' }}
            >
                ذكر
            </option>

            <option
                value="female"
                {{ old('gender') == 'female' ? 'selected' : '' }}
            >
                أنثى
            </option>

        </select>

        @error('gender')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- القسم --}}
    <div class="mb-3">

        <label class="form-label">
            القسم
        </label>

        <select
            name="department_id"
            class="form-select"
        >

            <option value="">
                -- بدون قسم --
            </option>

            @foreach($departments as $department)

                <option
                    value="{{ $department->id }}"
                    {{ old('department_id') == $department->id ? 'selected' : '' }}
                >
                    {{ $department->name }}
                </option>

            @endforeach

        </select>

        @error('department_id')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- العنوان --}}
    <div class="mb-3">

        <label class="form-label">
            العنوان
        </label>

        <textarea
            name="address"
            class="form-control"
            rows="3"
        >{{ old('address') }}</textarea>

        @error('address')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- التاريخ المرضي --}}
    <div class="mb-3">

        <label class="form-label">
            التاريخ المرضي
        </label>

        <textarea
            name="medical_history"
            class="form-control"
            rows="4"
            placeholder="أدخل المعلومات الطبية المهمة عن المريض"
        >{{ old('medical_history') }}</textarea>

        @error('medical_history')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- الحالة --}}
    <div class="mb-4">

        <label class="form-label">
            الحالة
        </label>

        <select
            name="status"
            class="form-select"
            required
        >

            <option value="1">
                نشط
            </option>

            <option value="0">
                متوقف
            </option>

        </select>

        @error('status')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- الأزرار --}}
    <div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            حفظ المريض
        </button>

        <a
            href="/patients"
            class="btn btn-secondary"
        >
            إلغاء
        </a>

    </div>

</form>

@endsection
