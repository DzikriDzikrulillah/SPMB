<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JalurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jalur')->insert([
            [
                'jalur' => 'Jalur Reguler',
                'deskripsi_jalur' => 'Jalur pendaftaran reguler untuk siswa umum.',
                'kuota' => '200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jalur' => 'Jalur Prestasi',
                'deskripsi_jalur' => 'Jalur pendaftaran khusus untuk siswa berprestasi.',
                'kuota' => '200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jalur' => 'Jalur Zonasi',
                'deskripsi_jalur' => 'Jalur pendaftaran untuk siswa berdasarkan jarak.',
                'kuota' => '200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jalur' => 'Jalur Afirmasi',
                'deskripsi_jalur' => 'Jalur pendaftaran untuk siswa dari keluarga tidak mampu.',
                'kuota' => '200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
