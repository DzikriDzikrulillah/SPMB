<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('hasil_waspas', function (Blueprint $table) {
            if (! Schema::hasColumn('hasil_waspas', 'us')) {
                $table->decimal('us', 8, 2)->after('nilai_akhir');
            }

            if (! Schema::hasColumn('hasil_waspas', 'normalisasi_us')) {
                $table->decimal('normalisasi_us', 12, 4)->after('normalisasi_nilai_akhir');
            }

            if (! Schema::hasColumn('hasil_waspas', 'status_seleksi')) {
                $table->string('status_seleksi')->nullable()->after('qi');
            }

            if (! Schema::hasColumn('hasil_waspas', 'status_akhir')) {
                $table->string('status_akhir')->nullable()->after('status_seleksi');
            }
        });
    }

    public function down()
    {
        Schema::table('hasil_waspas', function (Blueprint $table) {
            if (Schema::hasColumn('hasil_waspas', 'status_akhir')) {
                $table->dropColumn('status_akhir');
            }

            if (Schema::hasColumn('hasil_waspas', 'status_seleksi')) {
                $table->dropColumn('status_seleksi');
            }

            if (Schema::hasColumn('hasil_waspas', 'normalisasi_us')) {
                $table->dropColumn('normalisasi_us');
            }

            if (Schema::hasColumn('hasil_waspas', 'us')) {
                $table->dropColumn('us');
            }
        });
    }
};
