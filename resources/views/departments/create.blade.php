@extends('layouts.app')

@section('content')

<h2 class="mb-4">إضافة قسم جديد</h2>

<form action="/departments" method="POST">

    @csrf

    <div class="mb-3">
        <label class="form-label">اسم القسم</label>

        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>

        @error('name')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">الوصف</label>

        <textarea name="description" class="form-control">{{ old('description') }}</textarea>

        @error('description')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">الحالة</label>

        <select name="status" class="form-select">
            <option value="1">نشط</option>
            <option value="0">متوقف</option>
        </select>

        @error('status')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        حفظ القسم
    </button>

</form>

@endsection
