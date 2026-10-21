<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel soal pada instalasi lama dibuat di luar migration Laravel.
        if (Schema::hasTable('soal') && ! Schema::hasColumn('soal', 'idmateri')) {
            Schema::table('soal', function (Blueprint $table) {
                $table->unsignedBigInteger('idmateri')->nullable()->index();
            });
        }

        if (Schema::hasTable('soal') && Schema::hasColumn('soal', 'idmateri') && Schema::hasColumn('soal', 'idsoal')) {
            foreach (DB::table('soal')->whereNull('idmateri')->get(['idsoal']) as $soal) {
                DB::table('soal')->where('idsoal', $soal->idsoal)->update([
                    'idmateri' => (($soal->idsoal - 1) % 6) + 1,
                ]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('soal') && Schema::hasColumn('soal', 'idmateri')) {
            Schema::table('soal', function (Blueprint $table) {
                $table->dropColumn('idmateri');
            });
        }
    }
};
