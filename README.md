# SPMB-APP — Sistem Pendukung Keputusan Seleksi SPMB

\<p align="center">
&#x20; \<strong>Aplikasi Penerimaan Murid Baru Berbasis Web dengan Metode WASPAS\</strong>
\</p>

---

## 📖 Tentang Aplikasi

**SPMB-APP** adalah aplikasi manajemen **Sistem Penerimaan Murid Baru (SPMB)** berbasis web yang dibangun menggunakan framework **Laravel**. Aplikasi ini dilengkapi fitur **Sistem Pendukung Keputusan (SPK)** menggunakan metode **WASPAS (Weighted Aggregated Sum Product Assessment)** untuk membantu proses seleksi dan perangkingan calon murid baru secara objektif, sistematis, dan terukur.

Aplikasi ini dirancang untuk mempermudah pengelolaan proses penerimaan murid baru, mulai dari pendaftaran secara daring, pengelolaan data calon murid, verifikasi berkas, hingga proses seleksi berdasarkan kriteria dan bobot penilaian yang telah ditentukan.

## ✨ Fitur Utama

### 1. Website Pendaftaran dan Informasi

- Halaman informasi penerimaan murid baru.
- Formulir pendaftaran calon murid baru secara daring.
- Informasi jadwal dan periode pendaftaran.

### 2. Manajemen Pendaftaran

- Pengelolaan data calon murid baru.
- Monitoring status pendaftaran.
- Verifikasi data dan berkas persyaratan.
- Rekapitulasi seluruh data pendaftar.

### 3. Manajemen Gelombang

- Pengaturan periode atau gelombang pendaftaran.
- Pengelolaan jadwal pendaftaran.
- Pengaturan kuota penerimaan murid baru.

### 4. Sistem Pendukung Keputusan (SPK) — WASPAS

- Pengelolaan kriteria dan bobot penilaian.
- Penentuan jenis kriteria _Benefit_ dan _Cost_.
- Pembentukan matriks keputusan.
- Perhitungan normalisasi matriks keputusan.
- Perhitungan metode _Weighted Sum Model_ (WSM).
- Perhitungan metode _Weighted Product Model_ (WPM).
- Perhitungan nilai preferensi akhir (Qi).
- Perangkingan calon murid secara otomatis.

### 5. Export Data

- Export data pendaftar.
- Export hasil seleksi dan perangkingan.
- Dukungan format Excel (.xlsx) dan/atau CSV sesuai implementasi aplikasi.\\

---

## 🚀 Instalasi dan Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi SPMB-APP di lingkungan lokal.

### 1. Clone Repository

Buka terminal atau Git Bash, kemudian jalankan:

```bash
git clone https://github.com/DzikriDzikrulillah/SPMB-APP.git
```

Masuk ke direktori proyek:

```bash
cd SPMB-APP
```

### 2. Install Dependency Laravel

Jalankan perintah Composer:

```bash
composer install
```

Tunggu hingga seluruh dependency berhasil diinstal.

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

**Linux / macOS / Git Bash:**

```bash
cp .env.example .env
```

**Windows Command Prompt:**

```cmd
copy .env.example .env
```

### 4. Generate Application Key

Jalankan perintah:

```bash
php artisan key:generate
```

Perintah ini digunakan untuk menghasilkan application key yang dibutuhkan Laravel.

### 5. Konfigurasi Database

Buat database baru melalui phpMyAdmin atau MySQL.

Contoh nama database:

```sql
CREATE DATABASE spmb_app;
```

Kemudian buka file `.env` dan sesuaikan konfigurasi berikut:

```env
APP_NAME="SPMB-APP"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spmb_app
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan nama database, username, dan password berdasarkan konfigurasi MySQL pada perangkat masing-masing.

### 6. Jalankan Database Migration

Setelah database berhasil dikonfigurasi, jalankan:

```bash
php artisan migrate
```

Jika aplikasi menyediakan seeder untuk mengisi data awal, jalankan:

```bash
php artisan db:seed
```

Atau jalankan migration dan seeder sekaligus:

```bash
php artisan migrate --seed
```

**Catatan:** Jalankan seeder hanya jika file seeder tersedia dan memang diperlukan.

### 7. Buat Symbolic Link Storage

Jalankan perintah berikut untuk menghubungkan direktori penyimpanan file publik:

```bash
php artisan storage:link
```

### 8. Jalankan Aplikasi

Jalankan server development Laravel:

```bash
php artisan serve
```

---

## 🧮 Metode WASPAS

SPMB-APP menggunakan metode **WASPAS (Weighted Aggregated Sum Product Assessment)** untuk membantu proses pengambilan keputusan dalam seleksi calon murid baru.

Metode WASPAS menggabungkan dua pendekatan:

1. **Weighted Sum Model (WSM)**

    Menghitung nilai preferensi berdasarkan penjumlahan hasil perkalian bobot kriteria dengan nilai normalisasi setiap alternatif.

2. **Weighted Product Model (WPM)**

    Menghitung nilai preferensi berdasarkan perkalian nilai normalisasi yang dipangkatkan dengan bobot masing-masing kriteria.

3. **Perhitungan Nilai Preferensi Akhir (Qi)**

    Menggabungkan hasil WSM dan WPM untuk menghasilkan nilai preferensi akhir setiap alternatif.

4. **Perangkingan**

    Mengurutkan calon murid berdasarkan nilai preferensi akhir (Qi). Nilai yang lebih tinggi menunjukkan prioritas lebih tinggi berdasarkan kriteria dan bobot yang digunakan.

---

## 📁 Struktur Direktori

Berikut gambaran struktur direktori utama aplikasi:

```text
SPMB-APP/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── ...
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
│   ├── web.php
│   └── console.php
│
├── storage/
├── tests/
├── vendor/
│
├── .env.example
├── artisan
├── composer.json
└── README.md
```

_Struktur di atas merupakan gambaran umum Laravel dan dapat berbeda sesuai implementasi proyek._

##

---

## 📄 Lisensi dan Copyright

Copyright © 2026 **Dzikri Dzikrulillah**. All Rights Reserved.

SPMB-APP dikembangkan sebagai proyek aplikasi berbasis web untuk mendukung proses penerimaan murid baru dan penerapan Sistem Pendukung Keputusan menggunakan metode WASPAS.

Seluruh kode sumber, desain, struktur aplikasi, dan dokumentasi dalam repository ini merupakan bagian dari karya pengembang.

Penggunaan, penyalinan, modifikasi, distribusi, maupun publikasi ulang sebagian atau seluruh bagian dari proyek ini memerlukan izin tertulis dari pemilik hak cipta.

Framework dan pustaka pihak ketiga yang digunakan dalam proyek ini tetap tunduk pada lisensi masing-masing.

---

## 👨‍💻 Developer

**Dzikri Dzikrulillah**

- LinkedIn: [Dzikri Dzikrulillah](https://www.linkedin.com/in/dzikri-dzikrulillah/)

---

