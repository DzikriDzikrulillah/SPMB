<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAnalisisController;
use App\Http\Controllers\AdminSekolahController;
use App\Http\Controllers\AdminKontenController;
use App\Http\Controllers\AdminKontakController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ForgotPasswordController;

Route::group(['prefix' => '/'], function ($id = null) {
    Route::get('/', [ClientController::class, 'index'])->name('/');
    Route::get('/daftar', [ClientController::class, 'daftar'])->name('daftar');
    Route::post('/daftar/yes', [ClientController::class, 'yes_daftar'])->name('yes_daftar');
    Route::get('/dokumen/sptjm', [ClientController::class, 'downloadSptjm'])->name('sptjm.download');
    Route::get('/cek', [ClientController::class, 'cek'])->name('cek');
    Route::get('/cek/{id}/download', [ClientController::class, 'download'])->name('download.form');
    Route::post('/cek/{id}/download', [ClientController::class, 'download'])->name('download');
    Route::get('/aboutus', [ClientController::class, 'aboutus'])->name('aboutus');
    Route::get('/blog', [ClientController::class, 'blog'])->name('blog');
    Route::get('/informasi/{id}/baca', [ClientController::class, 'baca'])->name('baca', $id);
    Route::get('/faq', [ClientController::class, 'faq'])->name('faq');
    Route::get('/contactus', [ClientController::class, 'contactus'])->name('contactus');
    Route::post('/hub', [ClientController::class, 'hub'])->name('hub');
});

Auth::routes([
    'login' => false,
    'logout' => false,
    'register' => false,
    'reset' => false,
    'verify' => false,
    'confirm' => false,
]);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot_password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'submitForgotPassword']);
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset_password');
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPassword']);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'home/pendaftaran'], function () {

    Route::get('daftar_admin', [AdminController::class, 'daftar_admin'])
        ->name('daftar_admin');

    Route::post('daftar_admin/kirim_data', [AdminController::class, 'kirim_data'])
        ->name('kirim_data');

    // 🔹 VIEW
    Route::get('pendaftar/belum-acc', [AdminController::class, 'pendaftar_belum_acc'])
        ->name('pendaftar.belum_acc');

    Route::get('pendaftar/terverifikasi', [AdminController::class, 'pendaftar_terverifikasi'])
        ->name('pendaftar.terverifikasi');

    // 🔹 AKSI
    Route::get('pendaftar/{id}/lihat', [AdminController::class, 'lihat'])
        ->name('pendaftar.lihat');

    Route::get('pendaftar/{id}/hapus', [AdminController::class, 'hapus_siswa'])
        ->name('hapus_siswa');

    Route::get('pendaftar/{id}/acc', [AdminController::class, 'acc'])
        ->name('acc');

    Route::post('pendaftar/acc-massal', [AdminController::class, 'acc_massal'])
        ->name('acc_massal');

    // 🔹 EXPORT
    Route::get('export-pendaftar', [AdminController::class, 'exportPendaftar'])
        ->name('admin.export.pendaftar');
});


Route::group(['prefix' => 'home/analisis'], function () {

    // ==================
    // ATUR BOBOT
    // ==================
    Route::get('/bobot', [AdminAnalisisController::class, 'bobot'])
        ->name('admin.analisis.bobot');

    Route::post('/bobot/update', [AdminAnalisisController::class, 'updateBobot'])
        ->name('admin.analisis.bobot.update');


    // ==================
    // HASIL SAW
    // ==================
    Route::get(
        '/hasil-saw',
        [AdminAnalisisController::class, 'hasilSAW']
    )->name('saw');


    // ==================
    // HASIL WP
    // ==================
    Route::get(
        '/hasil-wp',
        [AdminAnalisisController::class, 'hasilWP']
    )->name('wp');


    // ==================
    // HASIL WASPAS
    // ==================
    Route::get(
        '/hasil-waspas',
        [AdminAnalisisController::class, 'hasilWaspas']
    )->name('admin.analisis.waspas.index');

    Route::post(
        '/hasil-waspas/proses',
        [AdminAnalisisController::class, 'prosesWaspas']
    )->name('admin.analisis.waspas.proses');

    Route::get(
        '/hasil-waspas/export',
        [AdminAnalisisController::class, 'exportWaspas']
    )->name('admin.analisis.waspas.export');
    /* ==============================
     * KEPUTUSAN AKHIR
     * ============================== */

    // Data diterima
    Route::get(
        '/diterima',
        [AdminAnalisisController::class, 'diterima']
    )->name('admin.analisis.seleksi.index');

    Route::post(
        '/diterima/otomatis',
        [AdminAnalisisController::class, 'seleksiOtomatis']
    )->name('admin.analisis.seleksi.otomatis');

    Route::post(
        '/diterima/{pendaftar}/manual',
        [AdminAnalisisController::class, 'seleksiManual']
    )->name('admin.analisis.seleksi.manual');

    // Generate surat penerimaan
    Route::get(
        '/diterima/{id}/cetak',
        [AdminAnalisisController::class, 'cetakSurat']
    )->name('diterima.cetak');


    /* ==============================
     * LAPORAN & EXPORT
     * ============================== */

    Route::get(
        '/laporan',
        [AdminAnalisisController::class, 'laporan']
    )->name('admin.analisis.laporan.index');

    Route::get(
        '/laporan/export-excel',
        [AdminAnalisisController::class, 'exportExcel']
    )->name('admin.analisis.laporan.excel');
});


Route::group(['prefix' => 'home/sekolah'], function ($id = null, $param = null) {
    Route::get('/jurusan', [AdminSekolahController::class, 'jurusan'])->name('jurusan');
    Route::delete('/jurusan/{id}/hapus_jurusan', [AdminSekolahController::class, 'hapus_jurusan'])->name('hapus_jurusan');
    Route::post('/add_jurusan', [AdminSekolahController::class, 'add_jurusan'])->name('add_jurusan');
    Route::get('/jurusan/{id}/edit', [AdminSekolahController::class, 'edit_jurusan'])->name('edit_jurusan');
    Route::put('/jurusan/{id}/update', [AdminSekolahController::class, 'update_jurusan'])->name('update_jurusan');
    Route::get('/jalur', [AdminSekolahController::class, 'jalur'])->name('jalur');
    Route::delete('/jalur/{id}/hapus_jalur', [AdminSekolahController::class, 'hapus_jalur'])->name('hapus_jalur');
    Route::post('/add_jalur', [AdminSekolahController::class, 'add_jalur'])->name('add_jalur');
    Route::get('/jalur/{id}/edit', [AdminSekolahController::class, 'edit_jalur'])->name('edit_jalur');
    Route::put('/jalur/{id}/update', [AdminSekolahController::class, 'update_jalur'])->name('update_jalur');
    Route::get('/gelombang', [AdminSekolahController::class, 'gelombang'])->name('gelombang');
    Route::get('/gelombang/edit_gelombang/{id}/{param}', [AdminSekolahController::class, 'edit_gelombang'])->name('edit_gelombang');
    Route::post('/add_gelombang', [AdminSekolahController::class, 'add_gelombang'])->name('add_gelombang');
    Route::get('/informasi_slide', [AdminKontenController::class, 'informasi_slide'])->name('informasi_slide');
    Route::post('/informasi_slide/post', [AdminKontenController::class, 'post_slide'])->name('post_slide');
    Route::get('/informasi_slide/{id}/hapus_slide', [AdminKontenController::class, 'hapus_slide'])->name('hapus_slide', $id);
    Route::get('/informasi_sekolah', [AdminKontenController::class, 'informasi_sekolah'])->name('informasi_sekolah');
    Route::post('/informasi_sekolah/post', [AdminKontenController::class, 'upload_informasi'])->name('upload_informasi');
    Route::get('/informasi_sekolah/{id}/edit_informasi', [AdminKontenController::class, 'edit_informasi'])->name('edit_informasi');
    Route::post('/informasi_sekolah/${id}/update_informasi', [AdminKontenController::class, 'update_informasi'])->name('update_informasi');
    Route::delete('/informasi_sekolah/{id}/hapus_informasi', [AdminKontenController::class, 'hapus_informasi'])->name('hapus_informasi');
    Route::get('/kategori', [AdminKontenController::class, 'category_manager'])->name('category_manager');
    Route::get('/kategori/{id}/edit_kategori', [AdminKontenController::class, 'category_edit'])->name('category_edit');
    Route::post('/kategori/post', [AdminKontenController::class, 'category_store'])->name('upload_kategori');
    Route::post('/kategori/{id}/edit_kategori', [AdminKontenController::class, 'category_update'])->name('category_update');
    Route::delete('/kategori/{id}/hapus_kategori', [AdminKontenController::class, 'category_delete'])->name('category_delete');
    Route::get('/kontak_admin', [AdminKontakController::class, 'kontak_admin'])->name('kontak_admin');
    Route::get('/kontak_admin/{id}/dibaca', [AdminKontakController::class, 'dibaca'])->name('dibaca', $id);
    Route::get('/kontak_admin/{id}/hapus_pesan', [AdminKontakController::class, 'hapus_pesan'])->name('hapus_pesan', $id);
    Route::get('/export-pendaftar', [AdminController::class, 'exportPendaftar'])->name('admin.export.pendaftar');
});
