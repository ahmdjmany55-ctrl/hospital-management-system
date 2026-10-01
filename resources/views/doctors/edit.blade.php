@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">
            تعديل بيانات الطبيب
        </h2>

        <a
            href="{{ route('doctors.index') }}"
            class="btn btn-secondary"
        >
            العودة إلى قائمة الأطباء
        </a>

    </div>

    {{-- رسائل الأخطاء --}}

    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>
                يرجى تصحيح الأخطاء التالية:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- رسالة النجاح --}}

    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">
                تعديل بيانات الطبيب وحساب الدخول
            </h5>

        </div>

        <div class="card-body">

            <form
                action="{{ route('doctors.update', $doctor->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')

                <div class="row">

                    {{-- اسم الطبيب --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            اسم الطبيب
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $doctor->name) }}"
                            required
                        >

                    </div>

                    {{-- البريد الإلكتروني --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            البريد الإلكتروني
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $doctor->email) }}"
                            required
                        >

                        <small class="text-muted">
                            هذا البريد يستخدم لتسجيل الدخول.
                        </small>

                    </div>

                    {{-- كلمة المرور الجديدة --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            كلمة المرور الجديدة
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="اتركها فارغة إذا لم ترد تغييرها"
                        >

                        <small class="text-muted">
                            إذا تركت الحقل فارغًا ستبقى كلمة المرور الحالية.
                        </small>

                    </div>

                    {{-- تأكيد كلمة المرور --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            تأكيد كلمة المرور الجديدة
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="أعد كتابة كلمة المرور الجديدة"
                        >

                    </div>

                    {{-- رقم الهاتف --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            رقم الهاتف
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone', $doctor->phone) }}"
                        >

                    </div>

                    {{-- التخصص --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            التخصص
                        </label>

                        <input
                            type="text"
                            name="specialization"
                            class="form-control"
                            value="{{ old('specialization', $doctor->specialization) }}"
                            required
                        >

                    </div>

                    {{-- القسم --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            القسم
                        </label>

                        <select
                            name="department_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                -- اختر القسم --
                            </option>

                            @foreach ($departments as $department)

                                <option
                                    value="{{ $department->id }}"
                                    {{ old('department_id', $doctor->department_id) == $department->id ? 'selected' : '' }}
                                >
                                    {{ $department->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- الجنس --}}

                    <div class="col-md-6 mb-3">

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
                                {{ old('gender', $doctor->gender) == 'male' ? 'selected' : '' }}
                            >
                                ذكر
                            </option>

                            <option
                                value="female"
                                {{ old('gender', $doctor->gender) == 'female' ? 'selected' : '' }}
                            >
                                أنثى
                            </option>

                        </select>

                    </div>

                    {{-- حالة الطبيب --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label d-block">
                            حالة الطبيب
                        </label>

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="status"
                                value="1"
                                id="status"
                                {{ old('status', $doctor->status) ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="status"
                            >
                                الطبيب نشط
                            </label>

                        </div>

                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        حفظ التعديلات
                    </button>

                    <a
                        href="{{ route('doctors.index') }}"
                        class="btn btn-secondary"
                    >
                        إلغاء
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
