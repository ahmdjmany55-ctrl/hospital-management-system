@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>إدارة المواعيد</h2>

    <a href="/appointments/create" class="btn btn-success">
        إضافة موعد جديد
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

                <th>المريض</th>

                <th>الطبيب</th>

                <th>التخصص</th>

                <th>التاريخ</th>

                <th>الوقت</th>

                <th>الحالة</th>

                <th>الملاحظات</th>

                <th>العمليات</th>

            </tr>

        </thead>


        <tbody>

        @forelse($appointments as $appointment)

            <tr>

                {{-- رقم الموعد --}}
                <td>
                    {{ $appointment->id }}
                </td>


                {{-- المريض --}}
                <td>

                    @if($appointment->patient)

                        {{ $appointment->patient->name }}

                    @else

                        -

                    @endif

                </td>


                {{-- الطبيب --}}
                <td>

                    @if($appointment->doctor)

                        د. {{ $appointment->doctor->name }}

                    @else

                        -

                    @endif

                </td>


                {{-- التخصص --}}
                <td>

                    @if($appointment->doctor)

                        {{ $appointment->doctor->specialization }}

                    @else

                        -

                    @endif

                </td>


                {{-- التاريخ --}}
                <td>

                    {{ $appointment->appointment_date->format('Y-m-d') }}

                </td>


                {{-- الوقت --}}
                <td>

                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}

                </td>


                {{-- الحالة --}}
                <td>

                    @if($appointment->status === 'scheduled')

                        <span class="badge bg-primary">
                            مجدول
                        </span>

                    @elseif($appointment->status === 'completed')

                        <span class="badge bg-success">
                            مكتمل
                        </span>

                    @elseif($appointment->status === 'cancelled')

                        <span class="badge bg-danger">
                            ملغي
                        </span>

                    @endif

                </td>


                {{-- الملاحظات --}}
                <td>

                    @if($appointment->notes)

                        {{ $appointment->notes }}

                    @else

                        -

                    @endif

                </td>


                {{-- العمليات --}}
                <td>

                    <a
                        href="/appointments/{{ $appointment->id }}/edit"
                        class="btn btn-warning btn-sm"
                    >
                        تعديل
                    </a>


                    <form
                        action="/appointments/{{ $appointment->id }}"
                        method="POST"
                        style="display:inline;"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('هل أنت متأكد من حذف هذا الموعد؟')"
                        >
                            حذف
                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="9"
                    class="text-center"
                >
                    لا توجد مواعيد حاليًا
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection
