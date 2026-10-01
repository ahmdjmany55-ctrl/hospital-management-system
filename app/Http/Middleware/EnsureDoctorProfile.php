<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDoctorProfile
{
    /**
     * التأكد من أن المستخدم الحالي طبيب ومرتبط بملف Doctor.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // 1. المستخدم غير مسجل دخول
        if (! $user) {
            return redirect()->route('login');
        }

        // 2. المستخدم ليس طبيباً
        if (! $user->isDoctor()) {
            abort(403, 'هذه الصفحة مخصصة للأطباء فقط.');
        }

        // 3. المستخدم طبيب لكن بدون ملف Doctor مرتبط
        if (! $user->doctor) {
            abort(403, 'حساب الطبيب غير مرتبط ببيانات طبيب في النظام.');
        }

        return $next($request);
    }
}
