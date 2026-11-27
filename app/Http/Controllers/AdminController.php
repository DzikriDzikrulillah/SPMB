<?php

namespace App\Http\Controllers;

use App\Exports\PendaftarExport;
use App\Models\Jurusan;
use App\Models\Jalur;
use App\Models\Gelombang;
use App\Models\BobotJalur;
use App\Models\Pendaftar;
use App\Services\WaspasService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{

    public function __construct(private WaspasService $waspasService)
    {
        $this->middleware('auth');
    }

    // Pendaftaran page admin
    public function daftar_admin()
    {
        $jurusan = Jurusan::all();
        $jalur = Jalur::all();
        $gelombang = Gelombang::where('status_gelombang', 'Buka')->first();

        $form = $gelombang ? '' : 'disabled';
        $button = $gelombang ? 'type="submit"' : 'type="button"';

        $page = "daftar_admin";
        return view('admin.pendaftar.daftar', compact(
            'jurusan',
            'jalur',
            'gelombang',
            'form',
            'button',
            'page'
        ));
    }

    /* ==========================
        SIMPAN DATA PENDAFTAR
    =========================== */
    public function kirim_data(Request $req)
    {
        $req->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'jarak_km' => 'required|numeric|min:0',
            'penghasilan_ayah' => 'required|numeric|min:0',
            'penghasilan_ibu' => 'required|numeric|min:0',
            'sktm' => 'required|mimes:pdf,jpeg,png,jpg|max:5120',
            'sptjm' => 'required|file|mimes:pdf|max:5120',
        ]);

        $pendaftar = new Pendaftar($req->except([
            'foto_profil',
            'transkrip_nilai',
            'skhun',
            'kartu_keluarga',
            'sktm',
            'sptjm'
        ]));

        if ($req->hasFile('foto_profil')) {
            $file = time() . '.' . $req->foto_profil->extension();
            $req->foto_profil->storeAs('public/foto_profil', $file);
            $pendaftar->foto_profil = 'foto_profil/' . $file;
        }

        if ($req->hasFile('transkrip_nilai')) {
            $file = time() . '_transkrip.pdf';
            $req->transkrip_nilai->storeAs('public/transkrip_nilai', $file);
            $pendaftar->transkrip_nilai = 'transkrip_nilai/' . $file;
        }

        if ($req->hasFile('skhun')) {
            $file = time() . '_skhun.pdf';
            $req->skhun->storeAs('public/skhun', $file);
            $pendaftar->skhun = 'skhun/' . $file;
        }

        if ($req->hasFile('kartu_keluarga')) {
            $file = time() . '_kk.pdf';
            $req->kartu_keluarga->storeAs('public/kartu_keluarga', $file);
            $pendaftar->kartu_keluarga = 'kartu_keluarga/' . $file;
        }


        // Compute and store distance from provided coordinates to school
        $schoolLat = -7.308688088643808;
        $schoolLng = 108.24370675150715;

        $pendaftar->latitude = $req->input('latitude');
        $pendaftar->longitude = $req->input('longitude');
        $computed = haversine_distance_km($pendaftar->latitude, $pendaftar->longitude, $schoolLat, $schoolLng);
        $pendaftar->jarak_km = round((float) $computed, 2);

        if ($req->hasFile('sktm')) {
            $file = time() . '_sktm.' . $req->sktm->getClientOriginalExtension();
            $req->sktm->storeAs('public/sktm', $file);
            $pendaftar->sktm = 'sktm/' . $file;
        }

        if ($req->hasFile('sptjm')) {
            $file = time() . '_sptjm.pdf';
            $req->sptjm->storeAs('public/sptjm', $file);
            $pendaftar->sptjm = 'sptjm/' . $file;
        }

        $pendaftar->save();

        return back()->with('success', 'Sukses Registrasi');
    }

    // 🔹 Belum ACC
    public function pendaftar_belum_acc()
    {
        $page = "pendaftar";
        $perPage = $this->resolvePerPage();
        $jalurList = $this->getJalurOptions();
        $gelombangList = $this->getGelombangOptions();
        $jurusanList = $this->getJurusanOptions();
        
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

        $data_pendaftar = $this->waspasService
            ->applyParticipantFilters(Pendaftar::query()->where('acc', 0), [
                'jalur' => $selectedJalur,
                'gelombang' => $selectedGelombang,
                'jurusan' => $selectedJurusan,
                'sort_by' => $sortBy,
            ])
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.pendaftar.belum_acc', compact(
            'data_pendaftar', 
            'page', 
            'jalurList', 
            'gelombangList',
            'jurusanList',
            'selectedJalur', 
            'selectedGelombang',
            'selectedJurusan',
            'sortBy', 
            'perPage'
        ));
    }

    // 🔹 Sudah ACC / Terverifikasi
    public function pendaftar_terverifikasi()
    {
        $page = "pendaftar_terverifikasi";
        $perPage = $this->resolvePerPage();
        $jalurList = $this->getJalurOptions();
        $gelombangList = $this->getGelombangOptions();
        $jurusanList = $this->getJurusanOptions();
        
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

        $data_acc = $this->waspasService
            ->applyParticipantFilters(Pendaftar::query()->where('acc', 1), [
                'jalur' => $selectedJalur,
                'gelombang' => $selectedGelombang,
                'jurusan' => $selectedJurusan,
                'sort_by' => $sortBy,
            ])
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.pendaftar.terverifikasi', compact(
            'data_acc', 
            'page', 
            'jalurList', 
            'gelombangList',
            'jurusanList',
            'selectedJalur', 
            'selectedGelombang',
            'selectedJurusan',
            'sortBy', 
            'perPage'
        ));
    }


    /* ==========================
        AKSI
    =========================== */
    public function acc($id)
    {
        Pendaftar::findOrFail($id)->update([
            'acc' => 1,
            'status_seleksi' => 'pending',
        ]);

        return back()->with('success', 'Siswa Telah Di ACC');
    }

    public function lihat($id)
    {
        $data = Pendaftar::findOrFail($id);
        return view('admin.pendaftar.lihat', compact('data'));
    }

    public function hapus_siswa($id)
    {
        Pendaftar::findOrFail($id)->delete();
        return back()->with('success', 'Data Dihapus');
    }

    public function acc_massal(Request $req)
    {
        $req->validate(['gelombang' => 'nullable|string']);

        $query = Pendaftar::query()->where('acc', 0);

        if ($req->gelombang !== 'all') {
            $query->where('gelombang', $req->gelombang);
        }

        $query->update([
            'acc' => 1,
            'status_seleksi' => 'pending',
        ]);

        return back()->with('success', 'ACC Massal Berhasil');
    }

    public function settingBobot()
    {
        $bobot = BobotJalur::all()->keyBy('jalur');
        return view('bobot.index', compact('bobot'));
    }

    public function exportPendaftar()
    {
        return Excel::download(new PendaftarExport(), 'data-pendaftar.xlsx');
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
        return Gelombang::query()
            ->orderBy('gelombang')
            ->pluck('gelombang')
            ->filter(fn($value) => filled($value))
            ->map(fn($value) => trim((string) $value))
            ->unique()
            ->values();
    }

    private function getJurusanOptions()
    {
        return Jurusan::query()
            ->orderBy('jurusan')
            ->pluck('jurusan')
            ->filter(fn($value) => filled($value))
            ->map(fn($value) => trim((string) $value))
            ->unique()
            ->values();
    }
}
