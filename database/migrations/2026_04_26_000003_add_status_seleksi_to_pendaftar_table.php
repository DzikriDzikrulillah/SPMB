<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->enum('status_seleksi', ['pending', 'diterima', 'ditolak'])
                ->default('pending')
                ->after('status_akhir');
            $table->decimal('nilai_preferensi', 14, 8)->nullable()->after('penghasilan_orangtua');
        });
    }

    public function down()
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn(['status_seleksi', 'nilai_preferensi']);
        });
    }
};
