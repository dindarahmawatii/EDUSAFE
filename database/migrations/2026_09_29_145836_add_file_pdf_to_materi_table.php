<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $table = Schema::hasTable('materis') ? 'materis' : 'materi';
        Schema::table($table, function (Blueprint $table) {
            $table->string('file_pdf')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $table = Schema::hasTable('materis') ? 'materis' : 'materi';
        Schema::table($table, function (Blueprint $table) {
            $table->dropColumn('file_pdf');
        });
    }
};
