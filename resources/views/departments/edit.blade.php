@extends('layouts.app')

@section('content')

<h2 class="mb-4">تعديل القسم</h2>

<form action="/departments/{{ $department->id }}" method="POST">

    @csrf

    @method('PUT')

    <div class="mb-3">
        <label class="form-label">اسم القسم</label>

        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name', $department->name) }}"
            required>
    </div>

    <div class="mb-3">
        <label class="form-label">الوصف</label>

        <textarea
            name="description"
            class="form-control">{{ old('description', $department->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">الحالة</label>

        <select name="status" class="form-select">

            <option value="1" {{ $department->status ? 'selected' : '' }}>
                نشط
            </option>

            <option value="0" {{ !$department->status ? 'selected' : '' }}>
                متوقف
            </option>

        </select>

    </div>

    <button class="btn btn-primary">
        تحديث القسم
    </button>

</form>

@endsection
