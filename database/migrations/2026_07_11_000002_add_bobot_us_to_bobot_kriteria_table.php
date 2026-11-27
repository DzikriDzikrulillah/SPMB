<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bobot_kriteria', function (Blueprint $table) {
            if (! Schema::hasColumn('bobot_kriteria', 'bobot_us')) {
                $table->decimal('bobot_us', 8, 4)->after('bobot_nilai_akhir')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('bobot_kriteria', function (Blueprint $table) {
            if (Schema::hasColumn('bobot_kriteria', 'bobot_us')) {
                $table->dropColumn('bobot_us');
            }
        });
    }
};
