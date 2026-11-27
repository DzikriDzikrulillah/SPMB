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
    protected $criteria;

    public function __construct($criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * Mengambil data berdasarkan kondisi dengan format yang sesuai
     *
     * @return Collection
     */
    public function collection()
    {
        $query = Pendaftar::query();

        // Filter berdasarkan kriteria yang dipilih
        if ($this->criteria == 0) {
            $query->where('acc', 0);
        } elseif ($this->criteria == 1) {
            $query->where('acc', 1);
        } elseif ($this->criteria == 'daful_0') {
            $query->where('daful', 0);
        } elseif ($this->criteria == 'daful_1') {
            $query->where('daful', 1);
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
                'Jarak'             => $item->jarak . ' KM',
                'Alamat'            => $item->alamat,
                'Daful'             => $item->daful == 1 ? 'Diterima' : 'Belum Diterima',
                'ACC'               => $item->acc == 1 ? 'Di ACC' : 'Belum ACC',
                'Created At'        => $item->created_at,
                'Updated At'        => $item->updated_at,
            ];
        });

        return collect($data);
    }

    /**
     * Judul sheet
     *
     * @return string
     */
    public function title(): string
    {
        if ($this->criteria == 0) {
            return 'Belum Di ACC';
        } elseif ($this->criteria == 1) {
            return 'Sudah Di ACC';
        } elseif ($this->criteria == 'daful_0') {
            return 'Belum Diterima';
        } elseif ($this->criteria == 'daful_1') {
            return 'Diterima';
        }

        return 'Sheet';
    }

    /**
     * Headings untuk tabel Excel
     *
     * @return array
     */
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
            'Jarak',
            'Alamat',
            'Daful',
            'Nilai ACC',
            'Created At',
            'Updated At',
        ];
    }
    /**
     * Mengatur style Excel
     *
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Menengahkan judul kolom (headings)
        $sheet->getStyle('A1:AJ1')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // Membuat data rata kiri
        $sheet->getStyle('A2:AJ' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ]);
    }
}

