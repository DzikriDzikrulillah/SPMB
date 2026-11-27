<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Pendaftar;

class pendaftarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //     public function run()
    //     {
    //         $setdisk = Storage::disk('local');
    //         if ($setdisk->missing('datasekolah.json')) {
    //             $convert = json_encode(getAPI());
    //             $setdisk->put('datasekolah.json', $convert);
    //         }
    //         $getdisk = Storage::get('datasekolah.json');
    //         $dataArray = json_decode($getdisk, true);
    //         for ($i = 0; $i <= 99; $i++) {
    //             Pendaftar::factory()->create([
    //                 'asal_sekolah' => $dataArray[$i]['sekolah'],

    //             ]);
    //         }
    //     }
    // }

    public function run()
    {
        // Mengecek apakah file datasekolah.json ada, jika tidak maka dibuat
        if (!Storage::exists('datasekolah.json')) {
            $convert = json_encode(getAPI()); // Pastikan fungsi getAPI() tersedia dan valid
            Storage::put('datasekolah.json', $convert);
        }

        // Membaca data dari datasekolah.json
        $dataArray = json_decode(Storage::get('datasekolah.json'), true);

        // Membuat pendaftar sebanyak 1000 data
        for ($i = 0; $i < 1000; $i++) {
            Pendaftar::factory()->create([
                'asal_sekolah' => $dataArray[array_rand($dataArray)]['sekolah'], // Memilih asal_sekolah secara acak
            ]);
        }
    }
}
