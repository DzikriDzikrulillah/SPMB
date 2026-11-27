<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Drop unused bobot_jalur table (replaced by bobot_kriteria)
        Schema::dropIfExists('bobot_jalur');

        // Remove duplicate ranking column from hasil_waspas (keep ranking_jalur)
        Schema::table('hasil_waspas', function (Blueprint $table) {
            if (Schema::hasColumn('hasil_waspas', 'ranking')) {
                $table->dropColumn('ranking');
            }
        });

        // Remove duplicate jarak column from pendaftar (keep jarak_km)
        Schema::table('pendaftar', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftar', 'jarak')) {
                $table->dropColumn('jarak');
            }
        });

        // Remove unused columns from pendaftar
        Schema::table('pendaftar', function (Blueprint $table) {
            // ranking is now stored in hasil_waspas table
            if (Schema::hasColumn('pendaftar', 'ranking')) {
                $table->dropColumn('ranking');
            }

            // status_akhir is replaced by status_seleksi
            if (Schema::hasColumn('pendaftar', 'status_akhir')) {
                $table->dropColumn('status_akhir');
            }

            // daful is legacy field, replaced by status_seleksi
            if (Schema::hasColumn('pendaftar', 'daful')) {
                $table->dropColumn('daful');
            }

            // nilai_preferensi is not used in current WASPAS logic
            if (Schema::hasColumn('pendaftar', 'nilai_preferensi')) {
                $table->dropColumn('nilai_preferensi');
            }
        });

        // Remove unused columns from hasil_waspas
        Schema::table('hasil_waspas', function (Blueprint $table) {
            // status_seleksi and status_akhir should be in pendaftar table only
            if (Schema::hasColumn('hasil_waspas', 'status_seleksi')) {
                $table->dropColumn('status_seleksi');
            }
            if (Schema::hasColumn('hasil_waspas', 'status_akhir')) {
                $table->dropColumn('status_akhir');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Recreate bobot_jalur table
        Schema::create('bobot_jalur', function (Blueprint $table) {
            $table->id();
            $table->string('jalur');
            $table->decimal('bobot_nilai', 5, 2);
            $table->decimal('bobot_jarak', 5, 2);
            $table->decimal('bobot_penghasilan', 5, 2);
            $table->timestamps();
        });

        // Restore ranking column to hasil_waspas
        Schema::table('hasil_waspas', function (Blueprint $table) {
            if (!Schema::hasColumn('hasil_waspas', 'ranking')) {
                $table->unsignedInteger('ranking')->after('qi');
            }
        });

        // Restore jarak column to pendaftar
        Schema::table('pendaftar', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftar', 'jarak')) {
                $table->decimal('jarak', 5, 2)->nullable()->after('rekomendasi');
            }
        });

        // Restore unused columns to pendaftar
        Schema::table('pendaftar', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftar', 'ranking')) {
                $table->integer('ranking')->nullable()->after('penghasilan_orangtua');
            }
            if (!Schema::hasColumn('pendaftar', 'status_akhir')) {
                $table->enum('status_akhir', ['DITERIMA', 'CADANGAN', 'TIDAK'])->nullable()->after('ranking');
            }
            if (!Schema::hasColumn('pendaftar', 'daful')) {
                $table->string('daful')->default(0)->nullable()->after('acc');
            }
            if (!Schema::hasColumn('pendaftar', 'nilai_preferensi')) {
                $table->decimal('nilai_preferensi', 8, 4)->nullable()->after('penghasilan_orangtua');
            }
        });

        // Restore unused columns to hasil_waspas
        Schema::table('hasil_waspas', function (Blueprint $table) {
            if (!Schema::hasColumn('hasil_waspas', 'status_seleksi')) {
                $table->string('status_seleksi')->nullable()->after('ranking_jalur');
            }
            if (!Schema::hasColumn('hasil_waspas', 'status_akhir')) {
                $table->enum('status_akhir', ['DITERIMA', 'CADANGAN', 'TIDAK'])->nullable()->after('status_seleksi');
            }
        });
    }
};
