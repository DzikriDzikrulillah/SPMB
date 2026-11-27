<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jurusan')->insert([
            [
                'jurusan' => 'Umum',
                'deskripsi_jurusan' => 'Jurusan untuk siswa dengan program pendidikan umum.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jurusan' => 'IPA',
                'deskripsi_jurusan' => 'Jurusan untuk siswa dengan program pendidikan sains dan teknologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jurusan' => 'IPS',
                'deskripsi_jurusan' => 'Jurusan untuk siswa dengan program pendidikan ilmu sosial.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
