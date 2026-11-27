<?php

namespace App\Exports;

use App\Models\Pendaftar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftarExport implements WithMultipleSheets
{
    /**
     * Membuat beberapa sheet dalam file Excel
     *
     * @return array
     */
    public function sheets(): array
    {
        return [
            new PendaftarSheet(0),  // Sheet untuk nilai ACC 0
            new PendaftarSheet(1),  // Sheet untuk nilai ACC 1
            new PendaftarSheet('daful_0'),  // Sheet untuk nilai DAful 0
            new PendaftarSheet('daful_1'),  // Sheet untuk nilai DAful 1
        ];
    }
}

