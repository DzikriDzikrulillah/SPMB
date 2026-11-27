<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Jalur;
use App\Models\Gelombang;

class AdminSekolahController extends Controller
{

    // function jurusan sekolah
    public function jurusan()
    {
        $data = Jurusan::all();
        $page = "jurusan";
        return view('admin/setting/jurusan', compact('data', 'page'));
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
        return view('admin/setting/edit_jurusan', compact('jurusan'));
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
        $page = 'jalur';

        return view('admin/setting/jalur', compact('data', 'page'));
    }

    public function add_jalur(Request $request)
    {
        $request->validate([
            'jalur' => 'required|string|max:255',
            'deskripsi_jalur' => 'required|string',
            'kuota' => 'nullable|integer|min:0',
        ]);

        Jalur::create([
            'jalur' => $request->jalur,
            'deskripsi_jalur' => $request->deskripsi_jalur,
            'kuota' => $request->kuota ?? 0,
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
        return view('admin/setting/edit_jalur', compact('jalur'));
    }

    public function update_jalur(Request $request, $id)
    {
        $request->validate([
            'jalur' => 'required|string|max:255',
            'deskripsi_jalur' => 'required|string',
            'kuota' => 'nullable|integer|min:0',
        ]);
        $jalur = Jalur::findOrFail($id);
        $jalur->update([
            'jalur' => $request->jalur,
            'deskripsi_jalur' => $request->deskripsi_jalur,
            'kuota' => $request->kuota ?? 0,
        ]);
        return redirect()->route('jalur')
            ->with('success', 'Data jalur berhasil diperbarui');
    }

    //function gelombang sekolah

    public function gelombang()
    {
        $data = Gelombang::all();
        $page = "gelombang";
        return view('admin/setting/gelombang', compact('data', 'page'));
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
}
