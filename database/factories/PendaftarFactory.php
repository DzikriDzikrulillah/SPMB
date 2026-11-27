<?php

namespace Database\Factories;


use App\Models\Pendaftar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pendaftar>
 */
class PendaftarFactory extends Factory
{
    protected $model = Pendaftar::class;

    public function definition(): array
    {
        $path = storage_path('app/datasekolah.json');
        $data = json_decode(file_get_contents($path), true);
        $asal_sekolah = array_map(function ($item) {
            return $item['sekolah'];
        }, $data);
        $saudara = $this->faker->numberBetween(0, 6);
        $statusAyah = $this->faker->randomElement(['Ada', 'Tidak ada']);
        $statusIbu = $this->faker->randomElement(['Ada', 'Tidak ada']);

        $penghasilanAyah = $statusAyah === 'Ada'
            ? $this->faker->numberBetween(1000000, 10000000)
            : 0;

        $penghasilanIbu = $statusIbu === 'Ada'
            ? $this->faker->numberBetween(1000000, 10000000)
            : 0;

        return [
            'gelombang' => $this->faker->randomElement(['Gelombang_1', 'Gelombang_2', 'Gelombang_3', 'Gelombang_4']),
            'jurusan' => $this->faker->randomElement(['Bahasa', 'IPS', 'IPA']),
            'jalur' => $this->faker->randomElement(['Reguler', 'Prestasi', 'Afirmasi', 'Zonasi']),

            'nama_siswa' => $this->faker->name(),
            'asal_sekolah' => $this->faker->randomElement($asal_sekolah),
            'nik' => $this->faker->unique()->nik(),
            'nisn' => $this->faker->regexify('[0-9]{10}'),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->dateTimeBetween('-18 years', '-15 years')->format('Y-m-d'),
            'jenis_kelamin' => $this->faker->randomElement(['Laki Laki', 'Perempuan']),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Hindu', 'Buddha', 'Konghucu']),
            'saudara' => $saudara = $this->faker->numberBetween(0, 6),
            'anak_ke' => $this->faker->numberBetween(1, $saudara + 1),


            'smt1' => $this->faker->numberBetween(65, 100),
            'smt2' => $this->faker->numberBetween(65, 100),
            'smt3' => $this->faker->numberBetween(65, 100),
            'smt4' => $this->faker->numberBetween(65, 100),
            'smt5' => $this->faker->numberBetween(65, 100),
            'smt6' => $this->faker->numberBetween(65, 100),
            'us' => $this->faker->numberBetween(65, 100),

            'nama_ayah' => $this->faker->name(),
            'nama_ibu' => $this->faker->name(),
            'pekerjaan_ayah' => $this->faker->jobTitle(),
            'pekerjaan_ibu' => $this->faker->jobTitle(),
            'status_ayah' => $statusAyah,
            'penghasilan_ayah' => $penghasilanAyah,
            'status_ibu' => $statusIbu,
            'penghasilan_ibu' => $penghasilanIbu,


            'hp_ayah' => '08' . $this->faker->numerify('##########'),
            'hp_ibu' => '08' . $this->faker->numerify('##########'),
            'hp_siswa' => '08' . $this->faker->numerify('##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'rekomendasi' => $this->faker->name(),
            'jarak_km' => $this->faker->randomFloat(2, 0.5, 10),
            'alamat' => $this->faker->address(),

            'foto_profil' => 'uploads/foto_profil/' . $this->faker->uuid . '.jpg',
            'transkrip_nilai' => 'uploads/transkrip_nilai/' . $this->faker->uuid . '.pdf',
            'skhun' => 'uploads/skhun/' . $this->faker->uuid . '.pdf',
            'kartu_keluarga' => 'uploads/kartu_keluarga/' . $this->faker->uuid . '.pdf',

            'acc' => $this->faker->randomElement(['0', '1']),
            'status_seleksi' => $this->faker->randomElement(['pending']),
            'sktm' => 'uploads/sktm/' . $this->faker->uuid . '.pdf',
            'latitude' => $this->faker->latitude(-7.5, -7.2),
            'longitude' => $this->faker->longitude(108.0, 108.4),
            'created_at' => $this->faker->dateTimeBetween('-2 months', '-10 days', 'Asia/Jakarta')
        ];
    }
}
