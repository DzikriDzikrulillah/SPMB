<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bobot_kriteria', function (Blueprint $table) {
            if (Schema::hasColumn('bobot_kriteria', 'min_qi')) {
                $table->dropColumn('min_qi');
            }
        });

        Schema::table('pendaftar', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftar', 'alasan_penolakan')) {
                $table->dropColumn('alasan_penolakan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bobot_kriteria', function (Blueprint $table) {
            if (! Schema::hasColumn('bobot_kriteria', 'min_qi')) {
                $table->decimal('min_qi', 14, 8)->default(0)->after('bobot_nilai_akhir');
            }
        });

        Schema::table('pendaftar', function (Blueprint $table) {
            if (! Schema::hasColumn('pendaftar', 'alasan_penolakan')) {
                $table->text('alasan_penolakan')->nullable()->after('status_seleksi');
            }
        });
    }
};
