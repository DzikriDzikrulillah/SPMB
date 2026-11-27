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
    public function up()
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id();
            // Gelombang
            $table->string('gelombang')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('jalur')->nullable();
            
            // Data siswa
            $table->string('nama_siswa');
            $table->string('asal_sekolah');
            $table->bigInteger('nik')->unique();
            $table->bigInteger('nisn');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('saudara');
            $table->string('anak_ke');

            //data Nilai
            $table->bigInteger('smt1');
            $table->bigInteger('smt2');
            $table->bigInteger('smt3');
            $table->bigInteger('smt4');
            $table->bigInteger('smt5');
            $table->bigInteger('smt6');
            $table->bigInteger('us');
            $table->decimal('akhir', 5, 2)->nullable();
            // Data ortu
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('status_ayah');
            $table->string('penghasilan_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('status_ibu');
            $table->string('penghasilan_ibu');

            // Data Kontak
            $table->string('hp_ayah')->nullable();
            $table->string('hp_ibu')->nullable();
            $table->string('hp_siswa');
            $table->string('email')->nullable();
            $table->string('rekomendasi')->nullable();
            $table->decimal('jarak', 5, 2)->nullable();
            $table->longText('alamat');

            //Upload
            $table->string('foto_profil'); 
            $table->string('transkrip_nilai'); 
            $table->string('skhun');
            $table->string('kartu_keluarga'); 

            // ACC 
            $table->string('acc')->default(0)->nullable();
            $table->string('daful')->default(0)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftar');
    }
};
