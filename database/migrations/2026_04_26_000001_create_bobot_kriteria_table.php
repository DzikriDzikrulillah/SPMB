<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bobot_kriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalur_id')->constrained('jalur')->cascadeOnDelete();
            $table->decimal('bobot_jarak', 8, 4);
            $table->decimal('bobot_penghasilan_orangtua', 8, 4);
            $table->decimal('bobot_nilai_akhir', 8, 4);
            $table->timestamps();

            $table->unique('jalur_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bobot_kriteria');
    }
};
