<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // الأعمدة diagnosis, medical_notes, prescription موجودة بالفعل في DB
        // لا شيء لفعله
    }

    public function down(): void
    {
        // لا شيء
    }
};
