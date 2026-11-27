<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $toDelete = ['hasil_waspas', 'bobot_kriteria', 'users', 'gelombang', 'pendaftar', 'informasi', 'categories'];
        Model::unguard();
        foreach ($toDelete as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::table($table)->delete();
            }
        }

        $this->call(CategorySeeder::class);
        $this->call(gelombangSeeder::class);
        $this->call(pendaftarSeeder::class);
        $this->call(userSeeder::class);
        $this->call(JalurSeeder::class);
        $this->call(BobotKriteriaSeeder::class);
        $this->call(JurusanSeeder::class);
        $this->call(InformasiSeeder::class);

        Model::reguard();
    }
}
