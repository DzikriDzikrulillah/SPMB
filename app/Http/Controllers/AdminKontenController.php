<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Informasi;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class AdminKontenController extends Controller
{
    // function informasi sekolah (blog)

    public function informasi_sekolah()
    {
        $page = "informasi_sekolah";
        $data = Informasi::orderBy('id', 'DESC')->get();
        $category = Category::all();
        return view('admin/setting/informasi', compact('data', 'page', 'category'));
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
        return view('admin/setting/edit_informasi', [
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
        return view('admin/setting/category', [
            'page' => 'category_manager',
            'data' => $data
        ]);
    }

    public function category_edit($id)
    {
        $data = Category::find($id);
        return view('admin/setting/edit_category', [
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
}
