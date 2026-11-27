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

        return [
            'gelombang' => $this->faker->randomElement(['Gelombang_1', 'Gelombang_2', 'Gelombang_3', 'Gelombang_4']),
            'jurusan'=> $this->faker->randomElement(['UMUM', 'IPS', 'IPA']),
            'jalur'=> $this->faker->randomElement(['Jalur Reguler', 'Jalur Prestasi', 'afirmasi', 'zonasi']),

            'nama_siswa'=> $this->faker->name(),
            'asal_sekolah'=> $this->faker->randomElement($asal_sekolah),
            'nik'=> $this->faker->nik(),
            'nisn'=> $this->faker->regexify('[0-9]{10}'),
            'tempat_lahir'=> $this->faker->city(),
            'tanggal_lahir'=> $this->faker->dateTimeThisCentury()->format('Y-m-d'),
            'jenis_kelamin'=> $this->faker->randomElement(['Laki Laki', 'Perempuan']),
            'agama'=> $this->faker->randomElement(['Islam', 'Kristen', 'Hindu', 'Buddha', 'Konghucu']),
            'saudara'=> $this->faker->numberBetween(1, 10),
            'anak_ke'=> $this->faker->numberBetween(1, 10),

            'smt1'=> $this->faker->numberBetween(60, 100),
            'smt2'=> $this->faker->numberBetween(60, 100),
            'smt3'=> $this->faker->numberBetween(60, 100),
            'smt4'=> $this->faker->numberBetween(60, 100),
            'smt5'=> $this->faker->numberBetween(60, 100),
            'smt6'=> $this->faker->numberBetween(60, 100),
            'us'=> $this->faker->numberBetween(60, 100),

            'nama_ayah'=> $this->faker->name(),
            'pekerjaan_ayah'=> $this->faker->jobTitle(),
            'status_ayah'=> $this->faker->randomElement(['Ada', 'Tidak ada']),
            'penghasilan_ayah'=> $this->faker->randomElement(['< 1 juta', '1-3 juta', '3-5 juta', '5-10 juta', '>10 juta']),
            'nama_ibu'=> $this->faker->name(),
            'pekerjaan_ibu'=> $this->faker->jobTitle(),
            'status_ibu'=> $this->faker->randomElement(['Ada', 'Tidak ada']),
            'penghasilan_ibu'=> $this->faker->randomElement(['< 1 juta', '1-3 juta', '3-5 juta', '5-10 juta', '>10 juta']),

            'hp_ayah'=> $this->faker->phoneNumber(),
            'hp_ibu'=> $this->faker->phoneNumber(),
            'hp_siswa'=> $this->faker->phoneNumber(),
            'email'=> $this->faker->unique()->safeEmail(),
            'rekomendasi'=> $this->faker->name(),
            'jarak'=> $this->faker->numberBetween(0, 100),
            'alamat'=> $this->faker->address(),

            'foto_profil' => 'uploads/foto_profil/' . $this->faker->uuid . '.jpg',
            'transkrip_nilai' => 'uploads/transkrip_nilai/' . $this->faker->uuid . '.pdf',
            'skhun' => 'uploads/skhun/' . $this->faker->uuid . '.pdf',
            'kartu_keluarga' => 'uploads/kartu_keluarga/' . $this->faker->uuid . '.pdf',


            'acc'=> $this->faker->randomElement(['0', '1']),
            'daful'=> $this->faker->randomElement(['0', '1']),
            'created_at'=> $this->faker->dateTimeBetween('-2 months', '-10 days', 'Asia/Jakarta')
        ];
    }
}
