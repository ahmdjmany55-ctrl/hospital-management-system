@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>إدارة المرضى</h2>

    <a href="/patients/create" class="btn btn-success">
        إضافة مريض جديد
    </a>

</div>


@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


<div class="table-responsive">

    <table class="table table-bordered table-striped align-middle">

        <thead class="table-primary">

            <tr>

                <th>#</th>

                <th>اسم المريض</th>

                <th>الهاتف</th>

                <th>البريد الإلكتروني</th>

                <th>تاريخ الميلاد</th>

                <th>الجنس</th>

                <th>القسم</th>

                <th>التاريخ المرضي</th>

                <th>الحالة</th>

                <th>العمليات</th>

            </tr>

        </thead>


        <tbody>

        @forelse($patients as $patient)

            <tr>

                {{-- رقم المريض --}}
                <td>
                    {{ $patient->id }}
                </td>


                {{-- اسم المريض --}}
                <td>
                    {{ $patient->name }}
                </td>


                {{-- الهاتف --}}
                <td>
                    {{ $patient->phone ?? '-' }}
                </td>


                {{-- البريد --}}
                <td>
                    {{ $patient->email ?? '-' }}
                </td>


                {{-- تاريخ الميلاد --}}
                <td>

                    @if($patient->date_of_birth)

                        {{ $patient->date_of_birth->format('Y-m-d') }}

                    @else

                        -

                    @endif

                </td>


                {{-- الجنس --}}
                <td>

                    @if($patient->gender === 'male')

                        ذكر

                    @elseif($patient->gender === 'female')

                        أنثى

                    @else

                        -

                    @endif

                </td>


                {{-- القسم --}}
                <td>

                    @if($patient->department)

                        {{ $patient->department->name }}

                    @else

                        بدون قسم

                    @endif

                </td>


                {{-- التاريخ المرضي --}}
                <td>

                    @if($patient->medical_history)

                        {{ $patient->medical_history }}

                    @else

                        -

                    @endif

                </td>


                {{-- الحالة --}}
                <td>

                    @if($patient->status)

                        <span class="badge bg-success">
                            نشط
                        </span>

                    @else

                        <span class="badge bg-danger">
                            متوقف
                        </span>

                    @endif

                </td>


                {{-- العمليات --}}
                <td>

                    <a
                        href="/patients/{{ $patient->id }}/edit"
                        class="btn btn-warning btn-sm"
                    >
                        تعديل
                    </a>


                    <form
                        action="/patients/{{ $patient->id }}"
                        method="POST"
                        style="display:inline;"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('هل أنت متأكد من حذف هذا المريض؟')"
                        >
                            حذف
                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="10"
                    class="text-center"
                >
                    لا يوجد مرضى حاليًا
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection
