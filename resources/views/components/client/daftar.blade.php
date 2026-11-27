<div class="container-xxl py-5 text-dark">
    <div class="container">
        <div class="text-center mx-auto" style="max-width: 500px">
            <h1 class="display-6 mb-5">
                Formulir Pendaftaran Online SMAN 1 SINDANGKASIH
            </h1>
        </div>

        <div class="row g-4 justify-content-center">
            <form action="{{ route('yes_daftar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- SECTION: Data Gelombang dan Jurusan -->
                    <div class="col-md-12">
                        <h3>Data Gelombang dan Jurusan</h3>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Gelombang</label>
                        <input type="text" value="{{ $gelombang->gelombang ?? 'Belum Ada Gelombang' }}" name="gelombang" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Status Gelombang</label>
                        <input type="text" value="{{ $gelombang->status_gelombang ?? 'Belum Di Buka' }}" class="form-control" disabled>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Jurusan Yang Diambil <sup class="text-danger">*</sup></label>
                        <select {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="jurusan" @endif class="form-select @error('jurusan') is-invalid @enderror">
                            <option disabled selected value="">Pilih Jurusan</option>
                            @foreach($jurusan as $jr)
                                <option value="{{ $jr->jurusan }}" {{ old('jurusan') == $jr->jurusan ? 'selected' : '' }}>{{ $jr->jurusan }}</option>
                            @endforeach
                        </select>
                        @error('jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Jalur Pendaftaran Yang Diambil <sup class="text-danger">*</sup></label>
                        <select {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="jalur" @endif class="form-select @error('jalur') is-invalid @enderror">
                            <option disabled selected value="">Pilih Jalur</option>
                            @foreach($jalur as $jl)
                                @php
                                    $jalurDisplay = preg_replace('/^Jalur\s+/i', '', trim($jl->jalur));
                                @endphp
                                <option value="{{ $jalurDisplay }}" {{ old('jalur') == $jalurDisplay ? 'selected' : '' }}>{{ $jalurDisplay }}</option>
                            @endforeach
                        </select>
                        @error('jalur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SECTION: Data Pendaftar -->
                    <div class="col-md-12 mt-4">
                        <h3>Data Pendaftar</h3>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Nama Lengkap Siswa <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" placeholder="Nama Siswa" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="nama_siswa" @endif value="{{ old('nama_siswa') }}">
                        @error('nama_siswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Asal Sekolah <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" placeholder="Asal Sekolah SMP/MTs" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="asal_sekolah" @endif value="{{ old('asal_sekolah') }}">
                        @error('asal_sekolah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3"> 
                        <label class="form-label">Nomor Induk Kependudukan (NIK) <sup class="text-danger">*</sup></label>
                        <input type="text" inputmode="numeric" maxlength="16" class="form-control @error('nik') is-invalid @enderror" placeholder="NIK Ada Di KK" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="nik" @endif value="{{ old('nik') }}">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Nomor Induk Siswa Nasional (NISN) <sup class="text-danger">*</sup></label>
                        <input type="text" inputmode="numeric" maxlength="10" class="form-control @error('nisn') is-invalid @enderror" placeholder="NISN" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="nisn" @endif value="{{ old('nisn') }}">
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Tempat Lahir <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Tempat Lahir Siswa" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="tempat_lahir" @endif value="{{ old('tempat_lahir') }}">
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Tanggal Lahir <sup class="text-danger">*</sup></label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="tanggal_lahir" @endif value="{{ old('tanggal_lahir') }}">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Jenis Kelamin <sup class="text-danger">*</sup></label>
                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="jenis_kelamin" @endif>
                            <option disabled selected value="">Pilih Jenis Kelamin</option>
                            <option value="Laki Laki" {{ old('jenis_kelamin') == 'Laki Laki' ? 'selected' : '' }}>Laki Laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Agama <sup class="text-danger">*</sup></label>
                        <select class="form-select @error('agama') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="agama" @endif>
                            <option disabled selected value="">Pilih Agama</option>
                            @foreach(['Islam', 'Kristen', 'Hindu', 'Budha', 'Konghuchu', 'Lainnya'] as $agama)
                                <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                            @endforeach
                        </select>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Jumlah Saudara <sup class="text-danger">*</sup></label>
                        <input type="number" class="form-control @error('saudara') is-invalid @enderror" placeholder="Jumlah Saudara" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="saudara" @endif value="{{ old('saudara') }}">
                        @error('saudara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Anak Ke <sup class="text-danger">*</sup></label>
                        <input type="number" class="form-control @error('anak_ke') is-invalid @enderror" placeholder="Anak Ke" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="anak_ke" @endif value="{{ old('anak_ke') }}">
                        @error('anak_ke')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SECTION: Data Nilai -->
                    <div class="col-md-12 mt-4">
                        <h3>Data Nilai</h3>
                    </div>

                    @for ($i = 1; $i <= 6; $i++)
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Semester {{ $i }} <sup class="text-danger">*</sup></label>
                            <input type="number" step="0.01" class="form-control @error('smt'.$i) is-invalid @enderror" placeholder="Rata-rata Nilai Semester {{ $i }}" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="smt{{ $i }}" @endif value="{{ old('smt'.$i) }}">
                            @error('smt'.$i)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endfor

                    <div class="col-md-12 mt-3">
                        <label class="form-label">Ujian Sekolah (US) / Ujian Madrasah (UM) <sup class="text-danger">*</sup></label>
                        <input type="number" step="0.01" class="form-control @error('us') is-invalid @enderror" placeholder="Rata-rata Nilai Ujian Sekolah" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="us" @endif value="{{ old('us') }}">
                        @error('us')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SECTION: Data Orang Tua -->
                    <div class="col-md-12 mt-4">
                        <h3>Data Orang Tua</h3>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Nama Ayah <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" placeholder="Nama Ayah" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="nama_ayah" @endif value="{{ old('nama_ayah') }}">
                        @error('nama_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Nama Ibu <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" placeholder="Nama Ibu" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="nama_ibu" @endif value="{{ old('nama_ibu') }}">
                        @error('nama_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Status Ayah <sup class="text-danger">*</sup></label>
                        <select class="form-select @error('status_ayah') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="status_ayah" @endif>
                            <option disabled selected value="">Pilih Status</option>
                            <option value="Masih Ada" {{ old('status_ayah') == 'Masih Ada' ? 'selected' : '' }}>Masih Ada</option>
                            <option value="Tidak Ada" {{ old('status_ayah') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('status_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Status Ibu <sup class="text-danger">*</sup></label>
                        <select class="form-select @error('status_ibu') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="status_ibu" @endif>
                            <option disabled selected value="">Pilih Status</option>
                            <option value="Masih Ada" {{ old('status_ibu') == 'Masih Ada' ? 'selected' : '' }}>Masih Ada</option>
                            <option value="Tidak Ada" {{ old('status_ibu') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('status_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @php
                        $pekerjaan_list = [
                            "Tidak Bekerja", "Nelayan", "Petani", "Peternak", "Guru",
                            "PNS/TNI/POLRI", "Karyawan Swasta", "Pedagang Kecil", "Pedagang Besar",
                            "Wiraswasta", "Wirausaha", "Buruh", "Pensiunan", "Lain-lain"
                        ];
                        $penghasilan_list = [
                            "< 1 juta", "1-3 juta", "3-5 juta", "5-10 juta", "> 10 juta"
                        ];
                    @endphp

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Pekerjaan Ayah <sup class="text-danger">*</sup></label>
                        <select class="form-select @error('pekerjaan_ayah') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="pekerjaan_ayah" @endif>
                            <option disabled selected value="">Pilih Pekerjaan</option>
                            @foreach($pekerjaan_list as $pekerjaan)
                                <option value="{{ $pekerjaan }}" {{ old('pekerjaan_ayah') == $pekerjaan ? 'selected' : '' }}>{{ $pekerjaan }}</option>
                            @endforeach
                        </select>
                        @error('pekerjaan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Pekerjaan Ibu <sup class="text-danger">*</sup></label>
                        <select class="form-select @error('pekerjaan_ibu') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="pekerjaan_ibu" @endif>
                            <option disabled selected value="">Pilih Pekerjaan</option>
                            @foreach($pekerjaan_list as $pekerjaan)
                                <option value="{{ $pekerjaan }}" {{ old('pekerjaan_ibu') == $pekerjaan ? 'selected' : '' }}>{{ $pekerjaan }}</option>
                            @endforeach
                        </select>
                        @error('pekerjaan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Penghasilan Ayah <sup class="text-danger">*</sup></label>
                        <input type="number" class="form-control @error('penghasilan_ayah') is-invalid @enderror" placeholder="Penghasilan Ayah (Rp)" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="penghasilan_ayah" @endif value="{{ old('penghasilan_ayah') }}">
                        @error('penghasilan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Penghasilan Ibu <sup class="text-danger">*</sup></label>
                        <input type="number" class="form-control @error('penghasilan_ibu') is-invalid @enderror" placeholder="Penghasilan Ibu (Rp)" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="penghasilan_ibu" @endif value="{{ old('penghasilan_ibu') }}">
                        @error('penghasilan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SECTION: Data Kontak -->
                    <div class="col-md-12 mt-4">
                        <h3>Data Kontak</h3>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Nomor HP Ayah<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control @error('hp_ayah') is-invalid @enderror" placeholder="Ex: 08xxxxxxxx" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="hp_ayah" @endif value="{{ old('hp_ayah') }}">
                        @error('hp_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Nomor HP Ibu<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" placeholder="Ex: 08xxxxxxxx" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="hp_ibu" @endif value="{{ old('hp_ibu') }}">
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Nomor HP Siswa <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control @error('hp_siswa') is-invalid @enderror" placeholder="Ex: 08xxxxxxxx" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="hp_siswa" @endif value="{{ old('hp_siswa') }}">
                        @error('hp_siswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Alamat Email Siswa <sup class="text-danger">*</sup></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Alamat Email" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="email" @endif value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Jarak ke Sekolah <sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control @error('jarak_km') is-invalid @enderror" placeholder="Kilometer" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="jarak_km" @endif value="{{ old('jarak_km') }}">
                            <button type="button" id="pick-on-map" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#mapModal">Pilih dari Peta</button>
                        </div>
                        <small class="form-text text-muted">Klik lokasi rumah pada peta untuk menghitung jarak ke sekolah.</small>
                        @error('jarak_km')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Direkomendasikan oleh<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" placeholder="Tahu SMAN 1 Sindangkasih dari?" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="rekomendasi" @endif value="{{ old('rekomendasi') }}">
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="form-label">Alamat <sup class="text-danger">*</sup></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat Lengkap Beserta RT & RW" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="alamat" @endif>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SECTION: Data Lampiran -->
                    <div class="col-md-12 mt-4">
                        <h3>Data Lampiran</h3>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="foto_profil" class="form-label">Foto Profil (JPG/PNG) <sup class="text-danger">*</sup></label>
                        <input type="file" id="foto_profil" class="form-control @error('foto_profil') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="foto_profil" @endif accept="image/*">
                        @if(isset($pendaftar) && $pendaftar->foto_profil)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $pendaftar->foto_profil) }}" alt="Foto Profil" class="img-thumbnail" width="150">
                            </div>
                        @endif
                        @error('foto_profil')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="transkrip_nilai" class="form-label">Transkrip Nilai (PDF) <sup class="text-danger">*</sup></label>
                        <input type="file" id="transkrip_nilai" class="form-control @error('transkrip_nilai') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="transkrip_nilai" @endif accept="application/pdf">
                        @if(isset($pendaftar) && $pendaftar->transkrip_nilai)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $pendaftar->transkrip_nilai) }}" target="_blank" class="btn btn-sm btn-primary">Lihat Transkrip Nilai</a>
                            </div>
                        @endif
                        @error('transkrip_nilai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="skhun" class="form-label">Ujian Sekolah (PDF) <sup class="text-danger">*</sup></label>
                        <input type="file" id="skhun" class="form-control @error('skhun') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="skhun" @endif accept="application/pdf">
                        @if(isset($pendaftar) && $pendaftar->skhun)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $pendaftar->skhun) }}" target="_blank" class="btn btn-sm btn-primary">Lihat SKHUN</a>
                            </div>
                        @endif
                        @error('skhun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="sktm" class="form-label">Slip Gaji / SKTM (PDF/JPG) <sup class="text-danger">*</sup></label>
                        <input type="file" id="sktm" class="form-control @error('sktm') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="sktm" @endif accept="application/pdf,image/*">
                        @if(isset($pendaftar) && $pendaftar->sktm)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $pendaftar->sktm) }}" target="_blank" class="btn btn-sm btn-primary">Lihat SKTM</a>
                            </div>
                        @endif
                        @error('sktm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="kartu_keluarga" class="form-label">Kartu Keluarga (PDF) <sup class="text-danger">*</sup></label>
                        <input type="file" id="kartu_keluarga" class="form-control @error('kartu_keluarga') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="kartu_keluarga" @endif accept="application/pdf">
                        @if(isset($pendaftar) && $pendaftar->kartu_keluarga)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $pendaftar->kartu_keluarga) }}" target="_blank" class="btn btn-sm btn-primary">Lihat Kartu Keluarga</a>
                            </div>
                        @endif
                        @error('kartu_keluarga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="sptjm" class="form-label">Surat Pernyataan Tanggung Jawab Mutlak (SPTJM) <sup class="text-danger">*</sup></label>
                        <input type="file" id="sptjm" class="form-control @error('sptjm') is-invalid @enderror" {{ $form ?? '' }} @if(($gelombang->status_gelombang ?? '') == 'Buka') name="sptjm" @endif accept="application/pdf" required>
                        <small class="form-text text-muted">Unduh blanko pada informasi pendaftaran, cetak, tanda tangani pendaftar dan orang tua/wali, lalu unggah dalam format PDF (maks. 5 MB).</small>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#sptjmModal">Baca ketentuan SPTJM</button>
                        @error('sptjm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-12 mt-4">
                        @if(($gelombang->status_gelombang ?? '') == 'Buka')
                            <button type="submit" class="btn btn-outline-success w-100 py-2">Kirim Datamu!</button>
                        @else
                            <button type="button" class="btn btn-outline-danger w-100 py-2" disabled>Pendaftaran Belum Di Buka!</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ketentuan SPTJM -->
<div class="modal fade" id="sptjmModal" tabindex="-1" aria-labelledby="sptjmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sptjmModalLabel">Ketentuan SPTJM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p>SPTJM wajib dicetak, diisi, dan ditandatangani sebelum diunggah.</p>
                <ol>
                    <li>Pendaftar dan orang tua/wali menyatakan seluruh data dan dokumen yang diserahkan benar serta sah.</li>
                    <li>Pendaftar dan orang tua/wali bersedia mengikuti proses verifikasi sekolah.</li>
                    <li>Jika ditemukan pemalsuan atau ketidakbenaran data, kelulusan dapat digugurkan atau pendaftar dapat dikeluarkan dari sekolah.</li>
                    <li>Orang tua/wali wajib membubuhkan paraf dan tanda tangan. Salah satu, ayah atau ibu, sudah cukup.</li>
                </ol>
                <a href="{{ route('sptjm.download') }}" class="btn btn-primary" target="_blank" rel="noopener">Unduh blanko SPTJM</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Informasi -->
<div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informasi Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Selamat Datang di Web SPMB SMAN 1 Sindangkasih. Mohon perhatikan aturan berikut sebelum mengisi formulir:</p>
                <ul>
                    <li>Isikan data dengan benar sesuai yang ada pada Kartu Keluarga (KK).</li>
                    <li>Perhatikan status gelombang apakah Buka atau Tutup.</li>
                    <li>Field dengan tanda (<span class="badge bg-danger">*</span>) wajib diisi.</li>
                    <li>Sebelum mendaftar, cek terlebih dahulu keberadaan data Anda pada link <a href="{{ url('/cek') }}"><span class="badge bg-success">Di Sini</span></a>.</li>
                    <li>Setelah mengisi, silakan verifikasi data Anda kembali pada link <a href="{{ url('/cek') }}"><span class="badge bg-success">Di Sini</span></a>.</li>
                    <li>Usahakan data rekomendasi terisi untuk mempermudah proses verifikasi.</li>
                    <li>SPTJM wajib dicetak, ditandatangani pendaftar dan orang tua/wali, lalu diunggah kembali.</li>
                </ul>
                <div class="alert alert-warning mb-0">
                    <strong>Unduh blanko SPTJM:</strong>
                    <a href="{{ route('sptjm.download') }}" class="alert-link" target="_blank" rel="noopener">Klik di sini untuk mengunduh</a>
                </div>
                <p class="mb-0">Terima kasih telah mendaftar di SMAN 1 Sindangkasih!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Peta Leaflet/Google Maps -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">Pilih Lokasi Rumah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="map" style="height: 500px; width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirm-location" class="btn btn-primary" data-bs-dismiss="modal">Pilih Lokasi</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>