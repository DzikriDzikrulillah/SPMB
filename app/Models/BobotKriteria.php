<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotKriteria extends Model
{
    use HasFactory;

    protected $table = 'bobot_kriteria';

    protected $fillable = [
        'jalur_id',
        'bobot_jarak',
        'bobot_penghasilan_orangtua',
        'bobot_nilai_akhir',
        'bobot_us',
    ];

    protected $casts = [
        'bobot_jarak' => 'float',
        'bobot_penghasilan_orangtua' => 'float',
        'bobot_nilai_akhir' => 'float',
        'bobot_us' => 'float',
    ];

    public function jalur()
    {
        return $this->belongsTo(Jalur::class);
    }
}
