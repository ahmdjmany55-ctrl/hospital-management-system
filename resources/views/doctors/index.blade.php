@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    <h2>إدارة الأطباء</h2>

    <a href="/doctors/create" class="btn btn-success">
        إضافة طبيب جديد
    </a>

</div>

<table class="table table-bordered table-striped">

    <thead class="table-primary">

        <tr>
            <th>#</th>
            <th>اسم الطبيب</th>
            <th>القسم</th>
            <th>التخصص</th>
            <th>البريد الإلكتروني</th>
            <th>رقم الهاتف</th>
            <th>الجنس</th>
            <th>الحالة</th>
            <th>العمليات</th>
        </tr>

    </thead>

    <tbody>

    @forelse($doctors as $doctor)

        <tr>

            <td>{{ $doctor->id }}</td>

            <td>{{ $doctor->name }}</td>

            <td>{{ $doctor->department->name }}</td>

            <td>{{ $doctor->specialization }}</td>

            <td>{{ $doctor->email ?? '-' }}</td>

            <td>{{ $doctor->phone ?? '-' }}</td>

            <td>
                @if($doctor->gender === 'male')
                    ذكر
                @else
                    أنثى
                @endif
            </td>

            <td>

                @if($doctor->status)

                    <span class="badge bg-success">
                        نشط
                    </span>

                @else

                    <span class="badge bg-danger">
                        متوقف
                    </span>

                @endif

            </td>

            <td>

                <a href="/doctors/{{ $doctor->id }}/edit"
   class="btn btn-warning btn-sm">
    تعديل
</a>

                <form action="/doctors/{{ $doctor->id }}"
      method="POST"
      style="display:inline;">

    @csrf

    @method('DELETE')

    <button
        type="submit"
        class="btn btn-danger btn-sm"
        onclick="return confirm('هل أنت متأكد من حذف هذا الطبيب؟')">

        حذف

    </button>

</form>

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="9" class="text-center">
                لا يوجد أطباء حاليًا
            </td>

        </tr>

    @endforelse

    </tbody>

</table>

@endsection

