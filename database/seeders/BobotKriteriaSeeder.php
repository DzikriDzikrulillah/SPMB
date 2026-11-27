<?php

namespace Database\Seeders;

use App\Models\Jalur;
use Illuminate\Database\Seeder;

class BobotKriteriaSeeder extends Seeder
{
    public function run()
    {
        Jalur::query()->get()->each(function (Jalur $jalur) {
            $name = strtolower(trim(preg_replace('/^jalur\s+/i', '', $jalur->jalur ?? '')));

            // default weights
            $weights = [
                'bobot_jarak' => 0.0,
                'bobot_penghasilan_orangtua' => 0.0,
                'bobot_nilai_akhir' => 0.0,
                'bobot_us' => 0.0,
            ];

            if (str_contains($name, 'reguler')) {
                $weights = [
                    'bobot_nilai_akhir' => 0.30, // C1
                    'bobot_us' => 0.30,          // C2
                    'bobot_jarak' => 0.20,      // C3
                    'bobot_penghasilan_orangtua' => 0.20, // C4
                ];
            } elseif (str_contains($name, 'zonasi')) {
                $weights = [
                    'bobot_nilai_akhir' => 0.25,
                    'bobot_us' => 0.25,
                    'bobot_jarak' => 0.40,
                    'bobot_penghasilan_orangtua' => 0.10,
                ];
            } elseif (str_contains($name, 'afirmasi')) {
                $weights = [
                    'bobot_nilai_akhir' => 0.25,
                    'bobot_us' => 0.25,
                    'bobot_jarak' => 0.10,
                    'bobot_penghasilan_orangtua' => 0.40,
                ];
            } elseif (str_contains($name, 'prestasi')) {
                $weights = [
                    'bobot_nilai_akhir' => 0.50,
                    'bobot_us' => 0.50,
                    'bobot_jarak' => 0.0,
                    'bobot_penghasilan_orangtua' => 0.0,
                ];
            }

            $jalur->bobotKriteria()->updateOrCreate(
                ['jalur_id' => $jalur->id],
                $weights
            );
        });
    }
}
