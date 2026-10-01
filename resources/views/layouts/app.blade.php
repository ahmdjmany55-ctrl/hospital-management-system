<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>نظام إدارة المستشفى</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            border-radius: 12px;
        }
        .table {
            background-color: white;
        }
        .alert {
            border-radius: 10px;
        }
        .btn {
            border-radius: 8px;
        }
    </style>
</head>

<body>

@if(auth()->check())

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ auth()->user()->isDoctor() ? '/doctor/dashboard' : '/dashboard' }}">
            🏥 نظام إدارة المستشفى
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">لوحة التحكم</a>
                    </li>
                @endif

                @if(auth()->user()->isDoctor())
                    <li class="nav-item">
                        <a class="nav-link" href="/doctor/dashboard">لوحة الطبيب</a>
                    </li>
                @endif

                @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link" href="/departments">الأقسام</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/doctors">الأطباء</a>
                    </li>
                @endif

                @if(auth()->user()->isAdmin() || auth()->user()->isReceptionist())
                    <li class="nav-item">
                        <a class="nav-link" href="/patients">المرضى</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/appointments">المواعيد</a>
                    </li>
                @endif

            </ul>

            <div class="d-flex align-items-center text-white">
                <span class="ms-3">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm">تسجيل الخروج</button>
                </form>
            </div>
        </div>
    </div>
</nav>

@endif

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>يوجد خطأ في البيانات المدخلة:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
