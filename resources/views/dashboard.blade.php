<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>لوحة تحكم المستشفى</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background-color: #f5f7fa;
        }

        .dashboard-card {
            border: none;
            border-radius: 15px;
            transition: 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .icon {
            font-size: 45px;
        }

        .welcome-card {
            border: none;
            border-radius: 15px;
        }

    </style>

</head>

<body>

<div class="container-fluid py-4">

    {{-- الترحيب --}}

    <div class="card welcome-card shadow-sm mb-4">

        <div class="card-body">

            <h2 class="fw-bold">
                🏥 مرحباً بك في نظام إدارة المستشفى
            </h2>

            <p class="text-muted mb-0">
                مرحباً {{ auth()->user()->name }}، هذه لوحة التحكم الرئيسية للنظام.
            </p>

        </div>

    </div>


    {{-- الإحصائيات --}}

    <div class="row g-4">


        {{-- الأقسام --}}

        <div class="col-md-6 col-lg-3">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-muted">
                                إجمالي الأقسام
                            </h6>

                            <h2 class="fw-bold">
                                {{ $departmentsCount }}
                            </h2>

                        </div>

                        <div class="icon">
                            🏥
                        </div>

                    </div>

                    <a
                        href="/departments"
                        class="btn btn-primary btn-sm mt-3"
                    >
                        عرض الأقسام
                    </a>

                </div>

            </div>

        </div>


        {{-- الأطباء --}}

        <div class="col-md-6 col-lg-3">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-muted">
                                إجمالي الأطباء
                            </h6>

                            <h2 class="fw-bold">
                                {{ $doctorsCount }}
                            </h2>

                        </div>

                        <div class="icon">
                            👨‍⚕️
                        </div>

                    </div>

                    <a
                        href="/doctors"
                        class="btn btn-success btn-sm mt-3"
                    >
                        عرض الأطباء
                    </a>

                </div>

            </div>

        </div>


        {{-- المرضى --}}

        <div class="col-md-6 col-lg-3">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-muted">
                                إجمالي المرضى
                            </h6>

                            <h2 class="fw-bold">
                                {{ $patientsCount }}
                            </h2>

                        </div>

                        <div class="icon">
                            🧑‍⚕️
                        </div>

                    </div>

                    <a
                        href="/patients"
                        class="btn btn-warning btn-sm mt-3"
                    >
                        عرض المرضى
                    </a>

                </div>

            </div>

        </div>


        {{-- المواعيد --}}

        <div class="col-md-6 col-lg-3">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-muted">
                                إجمالي المواعيد
                            </h6>

                            <h2 class="fw-bold">
                                {{ $appointmentsCount }}
                            </h2>

                        </div>

                        <div class="icon">
                            📅
                        </div>

                    </div>

                    <a
                        href="/appointments"
                        class="btn btn-info btn-sm mt-3"
                    >
                        عرض المواعيد
                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- إحصائيات المواعيد --}}

    <div class="row g-4 mt-2">


        <div class="col-md-6 col-lg-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        مواعيد اليوم
                    </h6>

                    <h3 class="fw-bold">
                        {{ $todayAppointmentsCount }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-6 col-lg-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        المواعيد المجدولة
                    </h6>

                    <h3 class="fw-bold">
                        {{ $scheduledAppointmentsCount }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-6 col-lg-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        المواعيد المكتملة
                    </h6>

                    <h3 class="fw-bold">
                        {{ $completedAppointmentsCount }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-6 col-lg-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        المواعيد الملغاة
                    </h6>

                    <h3 class="fw-bold">
                        {{ $cancelledAppointmentsCount }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


</div>

</body>

</html>
