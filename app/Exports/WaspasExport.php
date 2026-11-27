<?php

namespace App\Exports;

use App\Models\HasilWaspas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WaspasExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected ?string $jalur;
    protected ?string $gelombang;
    protected ?string $jurusan;
    protected ?string $sortBy;

    public function __construct(?string $jalur = null, ?string $gelombang = null, ?string $jurusan = null, ?string $sortBy = null)
    {
        $this->jalur = $jalur;
        $this->gelombang = $gelombang;
        $this->jurusan = $jurusan;
        $this->sortBy = $sortBy;
    }

    public function collection()
    {
        $query = HasilWaspas::query()->with('pendaftar');

        // Filter by jalur with normalization
        if ($this->jalur) {
            $jalur = $this->jalur;
            $normalizedJalur = strtolower(trim(preg_replace('/^jalur\s+/i', '', $jalur)));
            $query->where(function ($q) use ($jalur, $normalizedJalur) {
                $q->where('jalur', $jalur)
                    ->orWhere('jalur', 'like', '%' . $jalur . '%')
                    ->orWhereRaw('LOWER(jalur) = ?', [$normalizedJalur]);
            });
        }

        // Filter by gelombang (from pendaftar relationship)
        if ($this->gelombang) {
            $gelombang = $this->gelombang;
            $query->whereHas('pendaftar', function ($q) use ($gelombang) {
                $q->where('gelombang', $gelombang);
            });
        }

        // Filter by jurusan (from pendaftar relationship)
        if ($this->jurusan) {
            $jurusan = $this->jurusan;
            $query->whereHas('pendaftar', function ($q) use ($jurusan) {
                $q->where('jurusan', $jurusan);
            });
        }

        // Sorting
        if ($this->sortBy === 'qi') {
            $query->orderByDesc('qi');
        } elseif ($this->sortBy === 'nama') {
            $query->join('pendaftar as p', 'hasil_waspas.pendaftar_id', '=', 'p.id')
                ->orderBy('p.nama_siswa');
        } elseif ($this->sortBy === 'jarak') {
            $query->orderBy('jarak');
        } elseif ($this->sortBy === 'nilai') {
            $query->orderByDesc('nilai_akhir');
        } else {
            $query->orderBy('jalur')->orderBy('ranking_jalur');
        }

        $results = $query->get();

        $data = $results->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Ranking Jalur' => $item->ranking_jalur,
                'Nama Siswa' => $item->pendaftar->nama_siswa,
                'Asal Sekolah' => $item->pendaftar->asal_sekolah,
                'Jalur' => $item->jalur,
                'Gelombang' => $item->pendaftar->gelombang,
                'Jurusan' => $item->pendaftar->jurusan,
                'Nilai Rata-rata' => $item->nilai_akhir,
                'Nilai US' => $item->us,
                'Jarak (km)' => $item->jarak,
                'Penghasilan Orangtua' => $item->penghasilan_orangtua,
                'Normalisasi Nilai' => $item->normalisasi_nilai_akhir,
                'Normalisasi US' => $item->normalisasi_us,
                'Normalisasi Jarak' => $item->normalisasi_jarak,
                'Normalisasi Penghasilan' => $item->normalisasi_penghasilan_orangtua,
                'WSM' => $item->wsm,
                'WPM' => $item->wpm,
                'Nilai Qi' => $item->qi,
                'Status Seleksi' => ucfirst($item->pendaftar->status_seleksi ?? 'pending'),
            ];
        });

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Ranking Jalur',
            'Nama Siswa',
            'Asal Sekolah',
            'Jalur',
            'Gelombang',
            'Jurusan',
            'Nilai Rata-rata',
            'Nilai US',
            'Jarak (km)',
            'Penghasilan Orangtua',
            'Normalisasi Nilai',
            'Normalisasi US',
            'Normalisasi Jarak',
            'Normalisasi Penghasilan',
            'WSM',
            'WPM',
            'Nilai Qi',
            'Status Seleksi',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();

        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '4F81BD',
                ],
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
        ]);

        $sheet->getStyle("A2:{$highestColumn}" . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ]);

        // Center align numeric columns
        $sheet->getStyle("C2:C{$sheet->getHighestRow()}")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle("I2:T{$sheet->getHighestRow()}")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);
    }
}
