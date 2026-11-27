<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hasil_waspas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('pendaftar')->cascadeOnDelete();
            $table->string('jalur');
            $table->decimal('jarak', 10, 2);
            $table->decimal('penghasilan_orangtua', 15, 0);
            $table->decimal('nilai_akhir', 8, 2);
            $table->decimal('normalisasi_jarak', 12, 4);
            $table->decimal('normalisasi_penghasilan_orangtua', 12, 4);
            $table->decimal('normalisasi_nilai_akhir', 12, 4);
            $table->decimal('wsm', 14, 4);
            $table->decimal('wpm', 14, 4);
            $table->decimal('qi', 14, 4);
            $table->unsignedInteger('ranking');
            $table->unsignedInteger('ranking_jalur')->nullable();
            $table->timestamps();

            $table->unique('pendaftar_id');
            $table->index(['jalur', 'ranking']);
            $table->index('qi');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil_waspas');
    }
};
