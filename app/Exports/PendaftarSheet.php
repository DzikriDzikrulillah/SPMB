<?php

namespace App\Exports;

use App\Models\Pendaftar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendaftarSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithStyles
{
    protected string $criteria;

    public function __construct(string $criteria)
    {
        $this->criteria = $criteria;
    }

    public function collection()
    {
        $query = Pendaftar::query()->with('hasilWaspas');

        if ($this->criteria === 'acc') {
            $query->where('acc', 1);
        } elseif ($this->criteria === 'tidak_acc') {
            $query->where('acc', 0);
        } elseif ($this->criteria === 'diterima') {
            $query->where('status_seleksi', 'diterima');
        } elseif ($this->criteria === 'ditolak') {
            $query->where('status_seleksi', 'ditolak');
        }

        $data = $query->get()->map(function ($item, $index) {
            return [
                'No'                => $index + 1,
                'ID'                => $item->id,
                'Gelombang'         => $item->gelombang,
                'Jurusan'           => $item->jurusan,
                'Jalur'             => $item->jalur,
                'Nama Siswa'        => $item->nama_siswa,
                'Asal Sekolah'      => $item->asal_sekolah,
                'NIK'               => "'" . $item->nik, // Tambahkan tanda petik satu (')
                'NISN'              => $item->nisn,
                'Tempat Lahir'      => $item->tempat_lahir,
                'Tanggal Lahir'     => $item->tanggal_lahir,
                'Jenis Kelamin'     => $item->jenis_kelamin,
                'Agama'             => $item->agama,
                'Saudara'           => $item->saudara,
                'Anak Ke'           => $item->anak_ke,
                'SMT1'              => $item->smt1,
                'SMT2'              => $item->smt2,
                'SMT3'              => $item->smt3,
                'SMT4'              => $item->smt4,
                'SMT5'              => $item->smt5,
                'SMT6'              => $item->smt6,
                'US'                => $item->us,
                'Akhir'             => $item->akhir,
                'Nama Ayah'         => $item->nama_ayah,
                'Pekerjaan Ayah'    => $item->pekerjaan_ayah,
                'Nama Ibu'          => $item->nama_ibu,
                'Pekerjaan Ibu'     => $item->pekerjaan_ibu,
                'Status Ayah'       => $item->status_ayah,
                'Status Ibu'        => $item->status_ibu,
                'Penghasilan Ayah'  => $item->penghasilan_ayah,
                'Penghasilan Ibu'   => $item->penghasilan_ibu,
                'HP Ayah'           => $item->hp_ayah,
                'HP Ibu'            => $item->hp_ibu,
                'HP Siswa'          => $item->hp_siswa,
                'Email'             => $item->email,
                'Rekomendasi'       => $item->rekomendasi,
                'Jarak (km)'        => $item->jarak_km,
                'Alamat'            => $item->alamat,
                'SKTM'              => $item->sktm,
                'ACC'               => $item->acc == 1 ? 'ACC' : 'Belum ACC',
                'Status Seleksi'    => ucfirst($item->status_seleksi ?? 'pending'),
                'Created At'        => $item->created_at,
                'Updated At'        => $item->updated_at,
            ];
        });

        return collect($data);
    }

    public function title(): string
    {
        return match ($this->criteria) {
            'acc' => 'ACC',
            'tidak_acc' => 'Tidak ACC',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => 'Data',
        };
    }

    public function headings(): array
    {
        return [
            'No',
            'ID',
            'Gelombang',
            'Jurusan',
            'Jalur',
            'Nama Siswa',
            'Asal Sekolah',
            'NIK',
            'NISN',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Saudara',
            'Anak Ke',
            'SMT1',
            'SMT2',
            'SMT3',
            'SMT4',
            'SMT5',
            'SMT6',
            'US',
            'Akhir',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'Status Ayah',
            'Status Ibu',
            'Penghasilan Ayah',
            'Penghasilan Ibu',
            'HP Ayah',
            'HP Ibu',
            'HP Siswa',
            'Email',
            'Rekomendasi',
            'Jarak (km)',
            'Alamat',
            'SKTM',
            'ACC',
            'Status Seleksi',
            'Created At',
            'Updated At',
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
        ]);

        $sheet->getStyle("A2:{$highestColumn}" . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ]);
    }
}
