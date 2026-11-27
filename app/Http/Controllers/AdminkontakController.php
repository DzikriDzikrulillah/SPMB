<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontak;

class AdminkontakController extends Controller
{
    public function kontak_admin()
    {
        $data = Kontak::orderBy('id', 'DESC')->paginate(5);
        $page = 'kontak_admin';
        return view('admin/setting/kontak', compact('data', 'page'));
    }

    public function dibaca($id)
    {
        $baca = Kontak::find($id);
        $baca->update(['status' => 1]);
        $page = 'kontak_admin';
        return view('admin/setting/baca', compact('baca', 'page'));
    }

    public function hapus_pesan($id)
    {
        Kontak::find($id)->delete();
        return redirect()->back()->with('success', 'Sukses Menghapus Pesan');
    }
}
