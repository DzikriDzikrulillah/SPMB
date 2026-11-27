<?php

namespace App\Http\Controllers;

use App\Exports\PendaftarExport;
use Maatwebsite\Excel\Facades\Excel;
use FFI;
use App\Models\Kontak;
use App\Models\Jurusan;
use App\Models\Jalur;
use App\Models\Category;
use App\Models\Gelombang;
use App\Models\Informasi;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Pendaftaran page admin
    public function daftar_admin()
    {
        $jurusan = Jurusan::all();
        $jalur = Jalur::all();
        $gelombang = Gelombang::get()->where('status_gelombang', '=', 'Buka')->first();
        if ($gelombang == null) {
            $form = 'disabled';
            $button = 'type="button"';
            $name = '';
        } elseif ($gelombang->status_gelombang == 'Tutup') {
            $form = 'disabled';
            $button = 'type="button"';
            $name = '';
        } elseif ($gelombang->status_gelombang == 'Buka') {
            $form = '';
            $button = 'type="submit"';
        }
        $page = "daftar_admin";
        return view('Dashboard/pendaftar/daftar', compact('jurusan', 'jalur', 'gelombang', 'form', 'button', 'page'));
    }

    public function kirim_data(Request $req)
    {
        Pendaftar::create($req->only([
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
            'penghasilan_ayah' => 'required',
            'nama_ibu' => 'required',
            'status_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'penghasilan_ibu' => 'required',
            'hp_ayah' => 'nullable|string|max:15',
            'hp_ibu'  => 'nullable|string|max:15',
            'rekomendasi' => 'nullable|string',
            'hp_siswa' => 'required',
            'email' => 'required',
            'jarak' => 'required',
            'alamat' => 'required',
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'transkrip_nilai' => 'required|mimes:pdf|max:5120',
            'skhun' => 'required|mimes:pdf|max:5120',
            'kartu_keluarga' => 'required|mimes:pdf|max:5120',
        ]));

        $pendaftar = new Pendaftar($req->except(['foto_profil', 'transkrip_nilai', 'skhun', 'kartu_keluarga']));

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
        $pendaftar->save();

        return redirect()->back()->with('success', 'Sukses Melakukan Registrasi Online');
    }

    public function pendaftar()
    {
        $data_pendaftar = Pendaftar::orderBy('id', 'DESC')
            ->where('acc', '0')
            ->where('daful', '0')
            ->paginate(10);

        $data_acc = Pendaftar::orderBy('id', 'DESC')
            ->where('acc', '1')
            ->where('daful', '0')
            ->paginate(10);

        $belum_daful = Pendaftar::orderBy('id', 'DESC')
            ->where('acc', '1')
            ->where('daful', '0')
            ->paginate(10);

        $sudah_daful = Pendaftar::orderBy('id', 'DESC')
            ->where('acc', '1')
            ->where('daful', '1')
            ->paginate(10);

        $page = "pendaftar";

        return view(
            'Dashboard/pendaftar/pendaftar',
            compact('data_pendaftar', 'data_acc', 'belum_daful', 'sudah_daful', 'page')
        );
    }

    public function acc($id)
    {
        Pendaftar::findOrFail($id)->update([
            'acc' => 1
        ]);

        return redirect()->back()->with('success', 'Siswa Telah Di ACC');
    }

    public function daful($id)
    {
        Pendaftar::findOrFail($id)->update([
            'daful' => 1
        ]);

        return redirect()->back()->with('success', 'Siswa Telah Daftar Ulang');
    }

    public function lihat($id)
    {
        $data = Pendaftar::findOrFail($id);
        $page = "pendaftar";

        return view('Dashboard/pendaftar/lihat', compact('data', 'page'));
    }

    public function hapus_siswa($id)
    {
        Pendaftar::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data Siswa Berhasil Di Hapus');
    }

    public function acc_massal(Request $req)
    {
        $req->validate([
            'gelombang' => 'required'
        ]);

        $cek = Pendaftar::where('gelombang', $req->gelombang)->exists();

        if (!$cek) {
            return redirect()->back()->with('error', 'Gelombang Tersebut Belum Ada');
        }

        Pendaftar::where('gelombang', $req->gelombang)
            ->where('acc', '0')
            ->update([
                'acc' => 1
            ]);

        return redirect()->back()->with('success', 'Gelombang Tersebut Telah Di ACC');
    }

    // function jurusan sekolah
    public function jurusan()
    {
        $data = Jurusan::all();
        $page = "jurusan";
        return view('Dashboard/sekolah/jurusan', compact('data', 'page'));
    }

    public function add_jurusan(Request $req)
    {
        Jurusan::create([
            'jurusan' => $req->jurusan,
            'deskripsi_jurusan' => $req->deskripsi_jurusan
        ]);
        return redirect()->back()->with('success', 'Sukses Menambahkan Jurusan');
    }

    public function hapus_jurusan($id)
    {
        jurusan::find($id)->delete();
        return redirect()->back()->with('success', 'Sukses Menghapus Jurusan');
    }

    public function edit_jurusan($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('Dashboard/sekolah/edit_jurusan', compact('jurusan'));
    }

    public function update_jurusan(Request $request, $id)
    {
        $request->validate([
            'jurusan' => 'required|string|max:255',
            'deskripsi_jurusan' => 'required|string',
        ]);
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'jurusan' => $request->jurusan,
            'deskripsi_jurusan' => $request->deskripsi_jurusan,
        ]);
        return redirect()->route('jurusan')
            ->with('success', 'Jurusan berhasil diperbarui');
    }


    //function jalur sekolah

    public function jalur()
    {
        $data = Jalur::orderBy('id', 'DESC')->get();
        return view('Dashboard/sekolah/jalur', compact('data'));
    }
    public function add_jalur(Request $request)
    {
        $request->validate([
            'jalur' => 'required|string|max:255',
            'deskripsi_jalur' => 'required|string',
        ]);

        Jalur::create([
            'jalur' => $request->jalur,
            'deskripsi_jalur' => $request->deskripsi_jalur,
        ]);
        return redirect()->route('jalur')
            ->with('success', 'Data jalur berhasil ditambahkan');
    }

    public function hapus_jalur($id)
    {
        $jalur = Jalur::findOrFail($id);
        $jalur->delete();
        return redirect()->route('jalur')
            ->with('success', 'Data jalur berhasil dihapus');
    }

    public function edit_jalur($id)
    {
        $jalur = Jalur::findOrFail($id);
        return view('Dashboard/sekolah/edit_jalur', compact('jalur'));
    }

    public function update_jalur(Request $request, $id)
    {
        $request->validate([
            'jalur' => 'required|string|max:255',
            'deskripsi_jalur' => 'required|string',
        ]);
        $jalur = Jalur::findOrFail($id);
        $jalur->update([
            'jalur' => $request->jalur,
            'deskripsi_jalur' => $request->deskripsi_jalur,
        ]);
        return redirect()->route('jalur')
            ->with('success', 'Data jalur berhasil diperbarui');
    }

    //function gelombang sekolah

    public function gelombang()
    {
        $data = Gelombang::all();
        $page = "gelombang";
        return view('Dashboard/sekolah/gelombang', compact('data', 'page'));
    }

    public function add_gelombang(Request $req)
    {
        $req->validate([
            'gelombang' => 'required',
            'status_gelombang' => 'required'
        ]);
        Gelombang::first()->update([
            'gelombang' => $req->gelombang,
            'status_gelombang' => $req->status_gelombang,
        ]);
        return redirect()->back()->with('success', 'Sukses Update Gelombang');
    }

    public function edit_gelombang($id, $param)
    {
        Gelombang::where(['status_gelombang' => 'Buka'])->update(['status_gelombang' => 'Tutup']);
        Gelombang::where(['id' => $id])->update(['status_gelombang' => $param]);
        return redirect()->back()->with('success', 'Sukses update gelombang');
    }

    // function informasi sekolah (blog)

    public function informasi_sekolah()
    {
        $page = "informasi_sekolah";
        $data = Informasi::orderBy('id', 'DESC')->get();
        $category = Category::all();
        return view('Dashboard/sekolah/informasi', compact('data', 'page', 'category'));
    }

    public function upload_informasi(Request $req)
    {
        $req->validate([
            "judul" => 'required',
            "informasi" => 'required',
            "banner_image" => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "category" => 'required|integer'
        ]);
        if ($image = $req->file('banner_image')) {
            $image_path = 'storage/';
            $banner_image = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($image_path, $banner_image);
            $path = "storage/$banner_image";
        }
        Informasi::create(["judul" => $req->judul, "category_id" => $req->category, "informasi" => $req->informasi, "banner_image" => $path]);
        return redirect()->back()->with('success', 'Sukses Upload Informasi Sekolah');
    }

    public function edit_informasi($id)
    {
        $data = Informasi::find($id);
        $category = Category::all();
        return view('Dashboard/sekolah/edit_informasi', [
            "data" => $data,
            "category" => $category,
            "page" => 'informasi_sekolah'
        ]);
    }

    public function update_informasi(Request $req, $id)
    {
        $req->validate([
            "judul" => 'required',
            "informasi" => 'required',
            "category" => 'required|integer',
            "banner_image" => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $data = Informasi::find($id);
        $path = $data->banner_image;
        if ($image = $req->file('banner_image')) {
            $image_path = 'storage/';
            $banner_image = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($image_path, $banner_image);
            $path = "storage/$banner_image";
            File::delete($data->banner_image);
        }
        $data->update(["judul" => $req->judul, "informasi" => $req->informasi, "banner_image" => $path, "category_id" => $req->category]);
        return redirect()->route('informasi_sekolah')->with('success', 'Sukses Edit Informasi Sekolah');
    }

    public function hapus_informasi($id)
    {
        $data = Informasi::find($id);
        File::delete($data->banner_image);
        $data->delete();

        return redirect()->back()->with('success', 'Sukses Menghapus Informasi Sekolah');
    }

    // function category sekolah

    public function category_manager()
    {
        $data = Category::all();
        return view('dashboard/sekolah/category', [
            'page' => 'category_manager',
            'data' => $data
        ]);
    }

    public function category_edit($id)
    {
        $data = Category::find($id);
        return view('Dashboard/sekolah/edit_category', [
            "page" => "category_manager",
            "data" => $data
        ]);
    }

    public function category_update(Request $req, $id)
    {
        $req->validate([
            "category_name" => "required|unique:categories",
            "category_slug" => "required|unique:categories"
        ]);
        Category::find($id)->update(["category_name" => $req->category_name, "category_slug" => strtolower($req->category_slug)]);
        return redirect()->route('category_manager')->with('success', 'Sukses mengedit category');
    }

    public function category_delete($id)
    {
        Category::find($id)->delete();
        return redirect()->back()->with('success', 'Sukses menghapus category');
    }

    public function category_store(Request $req)
    {
        $req->validate([
            "category_name" => "required|unique:categories",
            "category_slug" => "required|unique:categories"
        ]);
        Category::create(["category_name" => $req->category_name, "category_slug" => strtolower($req->category_slug)]);
        return redirect()->back()->with('success', 'Sukses menambahkan category');
    }

    // function kontak admin
    public function kontak_admin()
    {
        $data = Kontak::orderBy('id', 'DESC')->paginate(5);
        $page = 'kontak_admin';
        return view('Dashboard/sekolah/kontak', compact('data', 'page'));
    }

    public function dibaca($id)
    {
        $baca = Kontak::find($id);
        $baca->update(['status' => 1]);
        $page = 'kontak_admin';
        return view('Dashboard/sekolah/baca', compact('baca', 'page'));
    }

    public function hapus_pesan($id)
    {
        Kontak::find($id)->delete();
        return redirect()->back()->with('success', 'Sukses Menghapus Pesan');
    }

    public function exportPendaftar()
    {
        return Excel::download(
            new PendaftarExport,
            'data-pendaftar-ppdb.xlsx'
        );
    }
}
