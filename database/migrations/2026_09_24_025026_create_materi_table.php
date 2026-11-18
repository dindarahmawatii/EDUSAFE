<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('materi')) {
            Schema::create('materi', function (Blueprint $table) {
                $table->id('idmateri');
                $table->string('judul')->nullable();
                $table->string('namamateri')->nullable();
                $table->string('kategori')->nullable();
                $table->text('deskripsi')->nullable();
                $table->text('konten')->nullable();
                $table->string('durasi')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
