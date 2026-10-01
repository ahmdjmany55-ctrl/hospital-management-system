<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>وصفة طبية — {{ $appointment->patient->name }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
    font-family: 'Segoe UI', Tahoma, sans-serif;
    padding: 10px;
    background: white;
}

@media print {
    @page {
        size: A4;
        margin: 15mm;
    }
    body {
        padding: 0;
    }
    .no-print {
        display: none;
    }
    .signature {
        page-break-inside: avoid;
    }
}

        .prescription-header {
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .clinic-name {
            font-size: 1.8rem;
            font-weight: bold;
            color: #0d6efd;
        }

        .rx-symbol {
            font-size: 3rem;
            font-weight: bold;
            color: #0d6efd;
        }

        .patient-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .prescription-body {
            min-height: 300px;
            white-space: pre-wrap;
            line-height: 2;
            font-size: 1.05rem;
        }

        .signature {
            margin-top: 60px;
            text-align: left;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            display: inline-block;
            padding-top: 5px;
        }

        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container">

    {{-- رأس الوصفة --}}
    <div class="prescription-header">
        <div class="row align-items-center">
            <div class="col-8">
                <div class="clinic-name">
                    🏥 نظام إدارة المستشفى
                </div>
                <div class="text-muted small mt-1">
                    وصفة طبية معتمدة
                </div>
            </div>
            <div class="col-4 text-end">
                <div class="rx-symbol">℞</div>
            </div>
        </div>
    </div>


    {{-- بيانات المريض والطبيب --}}
    <div class="row patient-info">
        <div class="col-md-6">
            <div class="row">
                <div class="col-4"><strong>المريض:</strong></div>
                <div class="col-8">{{ $appointment->patient->name ?? 'غير محدد' }}</div>
            </div>
            <div class="row mt-1">
                <div class="col-4"><strong>الهاتف:</strong></div>
                <div class="col-8">{{ $appointment->patient->phone ?? '-' }}</div>
            </div>
            <div class="row mt-1">
                <div class="col-4"><strong>العمر:</strong></div>
                <div class="col-8">
                    @if($appointment->patient->date_of_birth)
                        {{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age }} سنة
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-4"><strong>الطبيب:</strong></div>
                <div class="col-8">د. {{ $appointment->doctor->name ?? '-' }}</div>
            </div>
            <div class="row mt-1">
                <div class="col-4"><strong>التخصص:</strong></div>
                <div class="col-8">{{ $appointment->doctor->specialization ?? '-' }}</div>
            </div>
            <div class="row mt-1">
                <div class="col-4"><strong>التاريخ:</strong></div>
                <div class="col-8">
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->translatedFormat('j F Y') }}
                </div>
            </div>
        </div>
    </div>


    {{-- التشخيص --}}
    @if($appointment->diagnosis)
        <div class="mb-4">
            <h5 class="fw-bold border-bottom pb-2">
                <i class="bi bi-stethoscope text-primary"></i> التشخيص
            </h5>
            <p class="prescription-body">{{ $appointment->diagnosis }}</p>
        </div>
    @endif


    {{-- الوصفة --}}
    <div class="mb-4">
        <h5 class="fw-bold border-bottom pb-2">
            <i class="bi bi-prescription2 text-success"></i> الوصفة الطبية
        </h5>
        <div class="prescription-body">
            {{ $appointment->prescription ?? 'لا يوجد وصفة' }}
        </div>
    </div>


    {{-- الملاحظات --}}
    @if($appointment->medical_notes)
        <div class="mb-4">
            <h5 class="fw-bold border-bottom pb-2">
                <i class="bi bi-journal-text text-info"></i> ملاحظات إضافية
            </h5>
            <p class="prescription-body">{{ $appointment->medical_notes }}</p>
        </div>
    @endif


    {{-- التوقيع --}}
    <div class="signature text-end">
        <div class="signature-line"></div>
        <div class="mt-1">
            <strong>د. {{ $appointment->doctor->name ?? auth()->user()->name }}</strong>
        </div>
        <div class="text-muted small">
            {{ $appointment->doctor->specialization ?? '' }}
        </div>
    </div>


    {{-- أزرار التحكم (لا تظهر في الطباعة) --}}
    <div class="text-center mt-5 no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> طباعة
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            إغلاق
        </button>
    </div>

</div>

<script>
    // فتح نافذة الطباعة تلقائياً عند التحميل
    window.addEventListener('load', function() {
        setTimeout(function() {
            window.print();
        }, 500);
    });
</script>

</body>
</html>
