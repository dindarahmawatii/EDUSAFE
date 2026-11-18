<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('materi') && ! Schema::hasColumn('materi', 'deskripsi')) {
            Schema::table('materi', function (Blueprint $table) {
                $table->text('deskripsi')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('materi') && Schema::hasColumn('materi', 'deskripsi')) {
            Schema::table('materi', function (Blueprint $table) {
                $table->dropColumn('deskripsi');
            });
        }
    }
};
