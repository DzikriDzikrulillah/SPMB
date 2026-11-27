<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Jurusan;
use App\Models\Jalur;
use App\Models\Tentang;
use App\Models\Gelombang;
use App\Models\Informasi;
use App\Models\Kontak;
use App\Models\Pendaftar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ClientController extends Controller
{
    public function index()
    {
        $slide = Slider::all();
        $tentang = Tentang::first();
        $info = Informasi::orderBy('id', 'DESC')->limit(6)->get();

        // Gabungkan beberapa hitungan Pendaftar ke dalam satu query agregat untuk mengurangi jumlah kueri
        $hasStatusColumn = Pendaftar::hasSelectionStatusColumn();
        if ($hasStatusColumn) {
            $counts = Pendaftar::selectRaw("SUM(CASE WHEN acc = 0 THEN 1 ELSE 0 END) as jp, SUM(CASE WHEN status_seleksi = 'diterima' THEN 1 ELSE 0 END) as jt")->first();
        } else {
            $counts = Pendaftar::selectRaw("SUM(CASE WHEN acc = 0 THEN 1 ELSE 0 END) as jp, SUM(CASE WHEN acc = 1 THEN 1 ELSE 0 END) as jt")->first();
        }

        $jp = (int) ($counts->jp ?? 0);
        $jt = (int) ($counts->jt ?? 0);
        $jj = Jurusan::count();

        return view('Client/index', compact(
            'slide',
            'tentang',
            'info',
            'jp',
            'jt',
            'jj'
        ));
    }

    public function daftar()
    {
        $jurusan = Jurusan::all();
        $jalur = Jalur::all();
        $gelombang = Gelombang::where('status_gelombang', '=', 'Buka')->first();
        $form = $gelombang ? '' : 'disabled';
        $button = $gelombang ? 'type="submit"' : 'type="button"';

        return view('Client/daftar', compact('jurusan', 'jalur', 'gelombang', 'form', 'button'));
    }

    public function yes_daftar(Request $req)
    {
        $req->validate([
            'nik' => 'required|digits:16|unique:pendaftar,nik',
            'nik.unique' => 'NIK yang Anda masukkan sudah terdaftar.',
            'nik.digits' => 'NIK harus berisi 16 digit.',
        ]);
        if (Pendaftar::where('nik', $req->nik)->exists()) {
            return redirect()->back()->with('error', 'NIK yang Anda masukkan sudah terdaftar.');
        }
        $req->validate([
            'nisn' => 'required|digits:10|unique:pendaftar,nisn',
            'nisn.unique' => 'nisn yang Anda masukkan sudah terdaftar.',
            'nisn.digits' => 'nisn harus berisi 10 digit.',
        ]);
        if (Pendaftar::where('nisn', $req->nik)->exists()) {
            return redirect()->back()->with('error', 'NISN yang Anda masukkan sudah terdaftar.');
        }

        // Validasi Input
        $req->validate([
            'gelombang' => 'required',
            'jurusan' => 'required',
            'jalur' => 'required',
            'nama_siswa' => 'required',
            'asal_sekolah' => 'required',
            'nik' => 'required',
            'nisn' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'saudara' => 'required',
            'anak_ke' => 'required',
            'smt1' => 'required',
            'smt2' => 'required',
            'smt3' => 'required',
            'smt4' => 'required',
            'smt5' => 'required',
            'smt6' => 'required',
            'us' => 'required',
            'nama_ayah' => 'required',
            'status_ayah' => 'required',
            'pekerjaan_ayah' => 'required',
            'penghasilan_ayah' => 'required|numeric|min:0',
            'nama_ibu' => 'required',
            'status_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'penghasilan_ibu' => 'required|numeric|min:0',
            'hp_ayah' => 'nullable|string|max:15',
            'hp_ibu'  => 'nullable|string|max:15',
            'rekomendasi' => 'nullable|string',
            'hp_siswa' => 'required',
            'email' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'jarak_km' => 'required|numeric|min:0',
            'alamat' => 'required',
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'transkrip_nilai' => 'required|mimes:pdf|max:5120',
            'skhun' => 'required|mimes:pdf|max:5120',
            'kartu_keluarga' => 'required|mimes:pdf|max:5120',
            'sktm' => 'required|mimes:pdf,jpeg,png,jpg|max:5120',
            'sptjm' => 'required|file|mimes:pdf|max:5120',
        ]);
        $pendaftar = new Pendaftar($req->except(['foto_profil', 'transkrip_nilai', 'skhun', 'kartu_keluarga', 'sktm', 'sptjm']));

        // Upload Foto Profil
        if ($req->hasFile('foto_profil')) {
            $fileName = time() . '.' . $req->foto_profil->getClientOriginalExtension();
            $path = $req->foto_profil->storeAs('public/foto_profil', $fileName);
            $pendaftar->foto_profil = 'foto_profil/' . $fileName;
        }

        // Upload Transkrip Nilai
        if ($req->hasFile('transkrip_nilai')) {
            $fileName = time() . '_transkrip.pdf';
            $path = $req->transkrip_nilai->storeAs('public/transkrip_nilai', $fileName);
            $pendaftar->transkrip_nilai = 'transkrip_nilai/' . $fileName;
        }

        // Upload SKHUN
        if ($req->hasFile('skhun')) {
            $fileName = time() . '_skhun.pdf';
            $path = $req->skhun->storeAs('public/skhun', $fileName);
            $pendaftar->skhun = 'skhun/' . $fileName;
        }

        // Upload Kartu Keluarga
        if ($req->hasFile('kartu_keluarga')) {
            $fileName = time() . '_kk.pdf';
            $path = $req->kartu_keluarga->storeAs('public/kartu_keluarga', $fileName);
            $pendaftar->kartu_keluarga = 'kartu_keluarga/' . $fileName;
        }

        // Compute and store distance from provided coordinates to school
        $schoolLat = -7.308688088643808;
        $schoolLng = 108.24370675150715;

        $pendaftar->latitude = $req->input('latitude');
        $pendaftar->longitude = $req->input('longitude');
        // server-side compute to ensure integrity
        $computed = haversine_distance_km($pendaftar->latitude, $pendaftar->longitude, $schoolLat, $schoolLng);
        $pendaftar->jarak_km = round((float) $computed, 2);

        // Upload SKTM (sktm) - now required
        if ($req->hasFile('sktm')) {
            $fileName = time() . '_sktm.' . $req->sktm->getClientOriginalExtension();
            $req->sktm->storeAs('public/sktm', $fileName);
            $pendaftar->sktm = 'sktm/' . $fileName;
        }

        if ($req->hasFile('sptjm')) {
            $fileName = time() . '_sptjm.pdf';
            $req->sptjm->storeAs('public/sptjm', $fileName);
            $pendaftar->sptjm = 'sptjm/' . $fileName;
        }

        $pendaftar->save();

        return redirect()->back()->with('success', 'Sukses Melakukan Registrasi Online');
    }

    public function downloadSptjm()
    {
        return Pdf::loadView('Client.sptjm')->download('blanko-sptjm-spmb.pdf');
    }

    public function cek()
    {
        $data = Pendaftar::orderBy('id', 'DESC')->get();
        return view('Client/cek', compact('data'));
    }

    public function aboutus()
    {
        $data = Tentang::first();
        return view('Client/aboutus', compact('data'));
    }

    public function faq()
    {
        return view('Client/faq');
    }

    public function contactus()
    {
        return view('Client/contactus');
    }

    public function blog()
    {
        $info = Informasi::orderBy('id', 'DESC')->limit(9)->get();
        return view('Client/blog', compact('info'));
    }

    public function baca($id)
    {
        $data = Informasi::find($id);
        return view('Client/baca', compact('data'));
    }

    public function hub(Request $req)
    {
        $req->validate([
            'nama' => 'required',
            'nomor_hp' => 'required',
            'email' => 'required',
            'untuk' => 'required',
            'pesan' => 'required'
        ]);

        Kontak::create([
            'nama' => $req->input('nama'),
            'nomor_hp' => $req->input('nomor_hp'),
            'email' => $req->input('email'),
            'untuk' => $req->input('untuk'),
            'pesan' => $req->input('pesan')
        ]);

        return redirect()->back()->with('sukses', 'Terima kasih telah menghubungi kami.');
    }

    public function help()
    {
        return view('Client/tolong');
    }

    public function download(Request $request, $id)
    {
        $data = Pendaftar::findOrFail($id);

        // Jika request digunakan untuk langsung melakukan streaming/download PDF
        if ($request->has('download') && $request->download == '1') {
            if (! $data->isDiterima()) {
                return back()->with('error', 'Bukti penerimaan hanya tersedia untuk murid yang dinyatakan diterima.');
            }

            if ($request->nisn != $data->nisn) {
                return back()->with('error', 'NISN yang dimasukkan salah.');
            }

            $pdf = Pdf::loadView('Client.pdf', compact('data'));

            return $pdf->stream('bukti-diterima-' . $data->id . '.pdf');
        }

        // Alur verifikasi NISN: jika nisn benar, tampilkan halaman hasil seleksi
        if ($request->nisn != $data->nisn) {
            return back()->with('error', 'NISN yang dimasukkan salah.');
        }

        if ($data->status_seleksi === 'diterima') {
            return view('Client.hasil_diterima', ['data' => $data, 'nisn' => $request->nisn]);
        }

        if ($data->status_seleksi === 'ditolak') {
            return view('Client.hasil_ditolak', ['data' => $data]);
        }

        return back()->with('error', 'Status seleksi murid belum tersedia.');
    }
}
