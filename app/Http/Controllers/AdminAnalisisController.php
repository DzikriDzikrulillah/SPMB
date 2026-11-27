<?php

namespace App\Http\Controllers;

use App\Exports\PendaftarExport;
use App\Exports\WaspasExport;
use App\Models\HasilWaspas;
use App\Models\Jalur;
use App\Models\Pendaftar;
use App\Services\WaspasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminAnalisisController extends Controller
{
    public function __construct(private WaspasService $waspasService)
    {
        $this->middleware('auth');
    }

    public function bobot()
    {
        $page = 'bobot';
        $jalurList = Jalur::with('bobotKriteria')->orderBy('jalur')->get();

        return view('admin.analisis.bobot.bobot', compact('jalurList', 'page'));
    }

    public function updateBobot(Request $request)
    {
        $validated = $request->validate([
            'bobot' => ['required', 'array'],
            'bobot.*.jalur_id' => ['required', 'exists:jalur,id'],
            'bobot.*.bobot_jarak' => ['required', 'numeric', 'min:0', 'max:1'],
            'bobot.*.bobot_penghasilan_orangtua' => ['required', 'numeric', 'min:0', 'max:1'],
            'bobot.*.bobot_nilai_akhir' => ['required', 'numeric', 'min:0', 'max:1'],
            'bobot.*.bobot_us' => ['required', 'numeric', 'min:0', 'max:1'],
        ]);

        foreach ($validated['bobot'] as $item) {
            $total =
                (float) $item['bobot_jarak'] +
                (float) $item['bobot_penghasilan_orangtua'] +
                (float) $item['bobot_nilai_akhir'] +
                (float) $item['bobot_us'];

            if (abs($total - 1.0) > 0.0001) {
                return back()
                    ->withInput()
                    ->with('error', 'Total bobot setiap jalur harus tepat 1.00.');
            }
        }

        DB::transaction(function () use ($validated) {
            foreach ($validated['bobot'] as $item) {
                Jalur::findOrFail($item['jalur_id'])->bobotKriteria()->updateOrCreate(
                    ['jalur_id' => $item['jalur_id']],
                    [
                        'bobot_jarak' => $item['bobot_jarak'],
                        'bobot_penghasilan_orangtua' => $item['bobot_penghasilan_orangtua'],
                        'bobot_nilai_akhir' => $item['bobot_nilai_akhir'],
                        'bobot_us' => $item['bobot_us'],
                    ]
                );
            }
        });

        return back()->with('success', 'Bobot berhasil disimpan.');
    }

    public function hasilSAW()
    {
        return redirect()->route('admin.analisis.waspas.index');
    }

    public function hasilWP()
    {
        return redirect()->route('admin.analisis.waspas.index');
    }

    public function hasilWaspas()
    {
        $page = 'waspas_hasil';
        $perPage = $this->resolvePerPage();
        $selectedJalur = trim((string) request('jalur'));
        if ($selectedJalur === '') {
            $selectedJalur = null;
        }
        $selectedGelombang = trim((string) request('gelombang'));
        if ($selectedGelombang === '') {
            $selectedGelombang = null;
        }
        $selectedJurusan = trim((string) request('jurusan'));
        if ($selectedJurusan === '') {
            $selectedJurusan = null;
        }
        $sortBy = request('sort_by');

        $jalurOptions = $this->getJalurOptions();
        $gelombangOptions = $this->getGelombangOptions();
        $jurusanOptions = $this->getJurusanOptions();
        $info = $this->waspasService->getCalculationInfo();

        $hasil = $this->waspasService
            ->applyWaspasResultFilters($selectedJalur, $selectedGelombang, $selectedJurusan, $sortBy, $perPage)
            ->appends(request()->query());
        $extremes = $this->waspasService->getCriteriaExtremesForJalur($selectedJalur);

        if (
            $hasil->total() === 0 &&
            $info['approved_count'] > 0 &&
            empty($info['missing_weights']) &&
            $info['configured_weight_count'] > 0
        ) {
            $this->waspasService->calculate();
            $hasil = $this->waspasService
                ->applyWaspasResultFilters($selectedJalur, $selectedGelombang, $selectedJurusan, $sortBy, $perPage)
                ->appends(request()->query());
            $extremes = $this->waspasService->getCriteriaExtremesForJalur($selectedJalur);
        }

        return view('admin.analisis.waspas.hasil', compact(
            'hasil',
            'page',
            'info',
            'jalurOptions',
            'gelombangOptions',
            'jurusanOptions',
            'selectedJalur',
            'selectedGelombang',
            'selectedJurusan',
            'sortBy',
            'perPage',
            'extremes'
        ));
    }

    public function exportWaspas()
    {
        return Excel::download(
            new WaspasExport(),
            'hasil_waspas_' . date('Y-m-d_H-i-s') . '.xlsx'
        );
    }

    public function prosesWaspas()
    {
        $info = $this->waspasService->getCalculationInfo();

        if ($info['approved_count'] === 0) {
            return redirect()
                ->route('admin.analisis.waspas.index')
                ->with('error', 'Belum ada murid dengan status ACC untuk dihitung.');
        }

        if ($info['configured_weight_count'] === 0) {
            return redirect()
                ->route('admin.analisis.waspas.index')
                ->with('error', 'Bobot per jalur belum diisi. Silakan isi bobot terlebih dahulu.');
        }

        if (! empty($info['missing_weights'])) {
            return redirect()
                ->route('admin.analisis.waspas.index')
                ->with('error', 'Masih ada jalur ACC yang belum punya bobot: ' . implode(', ', $info['missing_weights']));
        }

        $hasil = $this->waspasService->calculate();

        return redirect()
            ->route('admin.analisis.waspas.index')
            ->with(
                $hasil->isEmpty() ? 'error' : 'success',
                $hasil->isEmpty()
                    ? 'Perhitungan dijalankan, tetapi belum menghasilkan data. Cek bobot dan data murid.'
                    : 'Perhitungan WASPAS berhasil diperbarui.'
            );
    }

    public function diterima()
    {
        $page = 'diterima';
        $perPage = $this->resolvePerPage();
        $selectedJalur = trim((string) request('jalur'));
        if ($selectedJalur === '') {
            $selectedJalur = null;
        }
        $selectedGelombang = trim((string) request('gelombang'));
        if ($selectedGelombang === '') {
            $selectedGelombang = null;
        }
        $selectedJurusan = trim((string) request('jurusan'));
        if ($selectedJurusan === '') {
            $selectedJurusan = null;
        }
        $sortBy = request('sort_by');

        $jalurOptions = $this->getJalurOptions();
        $gelombangOptions = $this->getGelombangOptions();
        $jurusanOptions = $this->getJurusanOptions();

        $hasil = $this->waspasService
            ->applyWaspasResultFilters($selectedJalur, $selectedGelombang, $selectedJurusan, $sortBy, $perPage)
            ->appends(request()->query());
        $summary = $this->waspasService->getSummary();

        return view('admin.analisis.diterima.index', compact(
            'page',
            'hasil',
            'summary',
            'jalurOptions',
            'gelombangOptions',
            'jurusanOptions',
            'selectedJalur',
            'selectedGelombang',
            'selectedJurusan',
            'sortBy',
            'perPage'
        ));
    }

    public function seleksiOtomatis(Request $request)
    {
        // Apply selection using kuota configured per jalur in `jalur` table
        $this->waspasService->autoSelectPerJalur();

        return back()->with('success', 'Seleksi otomatis per jalur berhasil dijalankan.');
    }

    public function seleksiManual(Request $request, Pendaftar $pendaftar)
    {
        $validated = $request->validate([
            'status_seleksi' => ['required', 'in:diterima,ditolak'],
        ]);

        $this->waspasService->setManualSelection(
            $pendaftar,
            $validated['status_seleksi']
        );

        return back()->with('success', 'Status seleksi murid berhasil diperbarui.');
    }

    public function cetakSurat($id)
    {
        return redirect()->route('download.form', $id);
    }

    public function laporan()
    {
        $page = 'laporan';
        $perPage = $this->resolvePerPage();
        $summary = $this->waspasService->getSummary();
        $acc = Pendaftar::query()->where('acc', 1)->latest()->paginate($perPage, ['*'], 'acc_page')->appends(request()->query());
        $tidakAcc = Pendaftar::query()->where('acc', 0)->latest()->paginate($perPage, ['*'], 'tidak_acc_page')->appends(request()->query());
        $diterima = Pendaftar::query()->where('status_seleksi', 'diterima')->latest()->paginate($perPage, ['*'], 'diterima_page')->appends(request()->query());
        $ditolak = Pendaftar::query()->where('status_seleksi', 'ditolak')->latest()->paginate($perPage, ['*'], 'ditolak_page')->appends(request()->query());

        return view('admin.analisis.laporan.index', compact(
            'page',
            'summary',
            'acc',
            'tidakAcc',
            'diterima',
            'ditolak',
            'perPage'
        ));
    }

    public function exportExcel()
    {
        return Excel::download(new PendaftarExport(), 'laporan-spmb.xlsx');
    }

    private function resolvePerPage(): int
    {
        return max(5, min((int) request('per_page', 10), 100));
    }

    private function getJalurOptions()
    {
        return Jalur::query()
            ->orderBy('jalur')
            ->pluck('jalur')
            ->filter(fn($value) => filled($value))
            ->map(fn($value) => trim((string) $value))
            ->unique()
            ->values();
    }

    private function getGelombangOptions()
    {
        return Pendaftar::query()
            ->orderBy('gelombang')
            ->pluck('gelombang')
            ->filter(fn($value) => filled($value))
            ->map(fn($value) => trim((string) $value))
            ->unique()
            ->values();
    }

    private function getJurusanOptions()
    {
        return Pendaftar::query()
            ->orderBy('jurusan')
            ->pluck('jurusan')
            ->filter(fn($value) => filled($value))
            ->map(fn($value) => trim((string) $value))
            ->unique()
            ->values();
    }
}
