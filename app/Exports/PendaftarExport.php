<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PendaftarExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new PendaftarSheet('acc'),
            new PendaftarSheet('tidak_acc'),
            new PendaftarSheet('diterima'),
            new PendaftarSheet('ditolak'),
        ];
    }
}
