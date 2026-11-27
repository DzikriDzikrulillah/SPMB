<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilWaspas extends Model
{
    use HasFactory;

    protected $table = 'hasil_waspas';

    protected $fillable = [
        'pendaftar_id',
        'jalur',
        'jarak',
        'penghasilan_orangtua',
        'nilai_akhir',
        'us',
        'normalisasi_jarak',
        'normalisasi_penghasilan_orangtua',
        'normalisasi_nilai_akhir',
        'normalisasi_us',
        'wsm',
        'wpm',
        'qi',
        'ranking_jalur',
    ];

    protected $casts = [
        'jarak' => 'float',
        'penghasilan_orangtua' => 'float',
        'nilai_akhir' => 'float',
        'us' => 'float',
        'normalisasi_jarak' => 'float',
        'normalisasi_penghasilan_orangtua' => 'float',
        'normalisasi_nilai_akhir' => 'float',
        'normalisasi_us' => 'float',
        'wsm' => 'float',
        'wpm' => 'float',
        'qi' => 'float',
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
}
