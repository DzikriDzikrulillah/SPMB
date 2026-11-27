<?php

namespace Tests\Feature;

use Illuminate\Support\Collection;
use Tests\TestCase;

class SelectionQuotaLegendTest extends TestCase
{
    public function test_selection_page_shows_quota_guidance_for_each_jalur(): void
    {
        $summary = [
            'jalur_summary' => [
                [
                    'jalur' => 'Afirmasi',
                    'kuota' => 2,
                    'total_pendaftar' => 5,
                    'total_acc' => 5,
                    'diterima' => 2,
                    'ditolak' => 3,
                    'pending' => 0,
                    'sisa_kuota' => 0,
                ],
            ],
        ];

        $hasil = new Collection([
            (object) [
                'ranking_jalur' => 1,
                'jalur' => 'Afirmasi',
                'qi' => 0.97,
                'pendaftar' => (object) [
                    'nama_siswa' => 'Budi',
                    'nisn' => '001',
                    'status_seleksi' => 'diterima',
                ],
            ],
            (object) [
                'ranking_jalur' => 3,
                'jalur' => 'Afirmasi',
                'qi' => 0.80,
                'pendaftar' => (object) [
                    'nama_siswa' => 'Ani',
                    'nisn' => '002',
                    'status_seleksi' => 'ditolak',
                ],
            ],
        ]);

        $view = view('admin.analisis.diterima.index', [
            'page' => 'diterima',
            'hasil' => $hasil,
            'summary' => $summary,
            'jalurOptions' => ['Afirmasi'],
            'gelombangOptions' => [],
            'jurusanOptions' => [],
            'selectedJalur' => null,
            'selectedGelombang' => null,
            'selectedJurusan' => null,
            'sortBy' => null,
            'perPage' => 10,
        ]);

        $html = (string) $view;

        $this->assertStringContainsString('direkomendasikan untuk diterima', strtolower($html));
        $this->assertStringContainsString('di luar kuota', strtolower($html));
        $this->assertStringContainsString('table-success-subtle', $html);
        $this->assertStringContainsString('table-danger-subtle', $html);
    }
}
