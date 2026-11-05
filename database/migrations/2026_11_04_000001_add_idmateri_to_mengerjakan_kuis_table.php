<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('mengerjakan_kuis')) {
            if (! Schema::hasColumn('mengerjakan_kuis', 'idmateri')) {
                Schema::table('mengerjakan_kuis', function (Blueprint $table) {
                    $table->unsignedBigInteger('idmateri')->nullable()->after('idkuis')->index();
                });
            }

            // Backfill baris pengerjaan kuis yang belum memiliki idmateri
            $rowsWithoutMateri = DB::table('mengerjakan_kuis')->whereNull('idmateri')->get();
            foreach ($rowsWithoutMateri as $row) {
                $idMateri = null;
                if (Schema::hasTable('soal') && Schema::hasColumn('soal', 'idmateri')) {
                    $idMateri = DB::table('soal')->where('idkuis', $row->idkuis)->whereNotNull('idmateri')->value('idmateri');
                }
                if (! $idMateri && Schema::hasTable('materi')) {
                    $idMateri = DB::table('materi')->value('idmateri') ?? DB::table('materi')->value('id');
                }
                if ($idMateri) {
                    DB::table('mengerjakan_kuis')->where('idmengerjakan', $row->idmengerjakan)->update([
                        'idmateri' => $idMateri,
                    ]);
                }
            }
        } else {
            Schema::create('mengerjakan_kuis', function (Blueprint $table) {
                $table->id('idmengerjakan');
                $table->unsignedBigInteger('iduser');
                $table->unsignedBigInteger('idkuis');
                $table->unsignedBigInteger('idmateri')->nullable()->index();
                $table->text('jawabanKuis')->nullable();
                $table->integer('nilai_akhir')->default(0);
                $table->string('status_kelulusan')->default('TIDAK LULUS');
                $table->timestamp('tanggal_pengerjaan')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('mengerjakan_kuis') && Schema::hasColumn('mengerjakan_kuis', 'idmateri')) {
            Schema::table('mengerjakan_kuis', function (Blueprint $table) {
                $table->dropColumn('idmateri');
            });
        }
    }
};
