@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    <h2>إدارة الأقسام</h2>

    <a href="/departments/create" class="btn btn-success">

        إضافة قسم جديد

    </a>

</div>

<table class="table table-bordered table-striped">

    <thead class="table-primary">

        <tr>

            <th>#</th>

            <th>اسم القسم</th>

            <th>الوصف</th>

            <th>الحالة</th>

            <th>العمليات</th>

        </tr>

    </thead>

    <tbody>

    @foreach($departments as $department)

        <tr>

            <td>{{ $department->id }}</td>

            <td>{{ $department->name }}</td>

            <td>{{ $department->description }}</td>

            <td>

                @if($department->status)

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

                <a href="/departments/{{ $department->id }}/edit"
   class="btn btn-warning btn-sm">
    تعديل
</a>

                <form action="/departments/{{ $department->id }}"
      method="POST"
      style="display:inline;">

    @csrf

    @method('DELETE')

    <button
        class="btn btn-danger btn-sm"
        onclick="return confirm('هل أنت متأكد من حذف هذا القسم؟')">

        حذف

    </button>

</form>

            </td>

        </tr>

    @endforeach

    </tbody>

</table>

@endsection
