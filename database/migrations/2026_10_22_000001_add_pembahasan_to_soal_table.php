<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('soal') && !Schema::hasColumn('soal', 'pembahasan')) {
            Schema::table('soal', function (Blueprint $table) {
                $table->text('pembahasan')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('soal') && Schema::hasColumn('soal', 'pembahasan')) {
            Schema::table('soal', function (Blueprint $table) {
                $table->dropColumn('pembahasan');
            });
        }
    }
};
