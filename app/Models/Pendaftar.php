<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $table = 'pendaftar';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'gelombang',
        'jurusan',
        'jalur',
        'nama_siswa',
        'asal_sekolah',
        'nik',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'saudara',
        'anak_ke',
        'smt1',
        'smt2',
        'smt3',
        'smt4',
        'smt5',
        'smt6',
        'us',
        'akhir',
        'nama_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'status_ayah',
        'status_ibu',
        'penghasilan_ayah',
        'penghasilan_ibu',
        'hp_ayah',
        'hp_ibu',
        'hp_siswa',
        'email',
        'rekomendasi',
        'jarak',
        'alamat',
        'foto_profil', 
        'transkrip_nilai', 
        'skhun', 
        'kartu_keluarga',
        'acc',
        'daful',
        'created_at',
        'updated_at',
    ];

    // Mutator untuk menghitung nilai akhir otomatis sebelum menyimpan
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->akhir = 
                ($model->smt1 * 0.125) + 
                ($model->smt2 * 0.125) + 
                ($model->smt3 * 0.125) + 
                ($model->smt4 * 0.125) + 
                ($model->smt5 * 0.125) + 
                ($model->smt6 * 0.125) + 
                ($model->us * 0.25);
        });
    }
}
