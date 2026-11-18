<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Melengkapi tabel evaluasi_instruktur: setiap baris = satu evaluasi
     * dari admin untuk satu siswa (riwayat disimpan, siswa melihat yang terbaru).
     */
    public function up(): void
    {
        Schema::table('evaluasi_instruktur', function (Blueprint $table) {
            if (! Schema::hasColumn('evaluasi_instruktur', 'iduser')) {
                $table->unsignedBigInteger('iduser')->index()->after('id');
            }
            if (! Schema::hasColumn('evaluasi_instruktur', 'idadmin')) {
                $table->unsignedBigInteger('idadmin')->nullable()->after('iduser');
            }
            if (! Schema::hasColumn('evaluasi_instruktur', 'catatan')) {
                $table->text('catatan')->after('idadmin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('evaluasi_instruktur', function (Blueprint $table) {
            foreach (['catatan', 'idadmin', 'iduser'] as $col) {
                if (Schema::hasColumn('evaluasi_instruktur', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
