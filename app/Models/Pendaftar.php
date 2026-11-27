<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

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
        'jarak_km',
        'alamat',
        'foto_profil',
        'transkrip_nilai',
        'skhun',
        'kartu_keluarga',
        'sptjm',
        'penghasilan_orangtua',
        'status_seleksi',
        'acc',
        'sktm',
        'latitude',
        'longitude',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'smt1' => 'float',
        'smt2' => 'float',
        'smt3' => 'float',
        'smt4' => 'float',
        'smt5' => 'float',
        'smt6' => 'float',
        'us' => 'float',
        'akhir' => 'float',
        'jarak_km' => 'float',
        'latitude' => 'float',
        'longitude' => 'float',
        'penghasilan_ayah' => 'float',
        'penghasilan_ibu' => 'float',
        'penghasilan_orangtua' => 'float',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->syncDerivedAttributes();
        });

        static::updating(function ($model) {
            $model->syncDerivedAttributes();
        });
    }

    public function hasilWaspas()
    {
        return $this->hasOne(HasilWaspas::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('acc', 1);
    }

    public function getStatusPendaftaranAttribute()
    {
        if (self::hasSelectionStatusColumn()) {
            return $this->status_seleksi ?? 'pending';
        }

        return (string) $this->daful === '1' ? 'diterima' : 'pending';
    }

    public function isDiterima(): bool
    {
        return $this->status_pendaftaran === 'diterima';
    }

    public function isDitolak(): bool
    {
        return $this->status_pendaftaran === 'ditolak';
    }

    public function getTanggalSuratAttribute(): string
    {
        return optional($this->updated_at ?? $this->created_at)->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y');
    }

    public function getJarakAttribute()
    {
        return $this->jarak_km ?? null;
    }

    public function syncDerivedAttributes(): void
    {
        $semester = array_filter([
            $this->smt1,
            $this->smt2,
            $this->smt3,
            $this->smt4,
            $this->smt5,
            $this->smt6,
        ], static fn($nilai) => $nilai !== null && $nilai !== '');

        $semester = array_map(static fn($nilai) => (float) $nilai, $semester);

        $this->akhir = count($semester) > 0
            ? round(array_sum($semester) / count($semester), 2)
            : 0.0;
        $this->penghasilan_orangtua = round(
            (float) ($this->penghasilan_ayah ?? 0) + (float) ($this->penghasilan_ibu ?? 0),
            2
        );
    }

    public static function hasSelectionStatusColumn(): bool
    {
        static $hasColumn;

        if ($hasColumn === null) {
            $hasColumn = Schema::hasColumn('pendaftar', 'status_seleksi');
        }

        return $hasColumn;
    }
}
