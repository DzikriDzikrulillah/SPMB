@php
    $isBuka = $gelombang && $gelombang->status_gelombang === 'Buka';
    $inputAttr = $isBuka ? '' : 'disabled';
    
    $pekerjaanList = [
        "Tidak Bekerja", "Nelayan", "Petani", "Peternak", "Guru",
        "PNS/TNI/POLRI", "Karyawan Swasta", "Pedagang Kecil", "Pedagang Besar",
        "Wiraswasta", "Wirausaha", "Buruh", "Pensiunan", "Lain-lain"
    ];

    $penghasilanList = [
        "< 1 juta", "1-3 juta", "3-5 juta", "5-10 juta", "> 10 juta"
    ];
@endphp

<div class="row g-4 justify-content-center">
    <form action="{{ route('kirim_data') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- DATA GELOMBANG & JURUSAN -->
            <div class="col-md-12">
                <h3>Data Gelombang dan Jurusan</h3>
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="form-label">Gelombang</label>
                <input type="text" value="{{ $gelombang->gelombang ?? 'Belum Ada Gelombang' }}" name="gelombang_display" class="form-control" readonly disabled>
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="form-label">Status Gelombang</label>
                <input type="text" value="{{ $gelombang->status_gelombang ?? 'Belum Dibuka' }}" class="form-control" disabled>
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="form-label">Jurusan Yang Diambil <sup class="text-danger">*</sup></label>
                <select {{ $inputAttr }} name="jurusan" class="form-select @error('jurusan') is-invalid @enderror">
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
                <select {{ $inputAttr }} name="jalur" class="form-select @error('jalur') is-invalid @enderror">
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

            <!-- DATA PENDAFTAR -->
            <div class="col-md-12 mt-4">
                <h3>Data Pendaftar</h3>
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="form-label">Nama Lengkap Siswa <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" placeholder="Nama Siswa" {{ $inputAttr }} name="nama_siswa" value="{{ old('nama_siswa') }}">
                @error('nama_siswa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="form-label">Asal Sekolah <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" placeholder="Asal Sekolah SMP/MTs" {{ $inputAttr }} name="asal_sekolah" value="{{ old('asal_sekolah') }}">
                @error('asal_sekolah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mt-3"> 
                <label class="form-label">Nomor Induk Kependudukan (NIK) <sup class="text-danger">*</sup></label>
                <input type="number" maxlength="16" class="form-control @error('nik') is-invalid @enderror" placeholder="NIK Ada Di KK" {{ $inputAttr }} name="nik" value="{{ old('nik') }}">
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="form-label">Nomor Induk Siswa Nasional (NISN) <sup class="text-danger">*</sup></label>
                <input type="number" maxlength="10" class="form-control @error('nisn') is-invalid @enderror" placeholder="NISN" {{ $inputAttr }} name="nisn" value="{{ old('nisn') }}">
                @error('nisn')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="form-label">Tempat Lahir <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Tempat Lahir Siswa" {{ $inputAttr }} name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                @error('tempat_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="form-label">Tanggal Lahir <sup class="text-danger">*</sup></label>
                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" {{ $inputAttr }} name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                @error('tanggal_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="form-label">Jenis Kelamin <sup class="text-danger">*</sup></label>
                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" {{ $inputAttr }} name="jenis_kelamin">
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="Laki Laki" {{ old('jenis_kelamin') == 'Laki Laki' ? 'selected' : '' }}>Laki Laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="form-label">Agama <sup class="text-danger">*</sup></label>
                <select class="form-select @error('agama') is-invalid @enderror" {{ $inputAttr }} name="agama">
                    <option value="" disabled selected>Pilih Agama</option>
                    @foreach(['Islam', 'Kristen', 'Hindu', 'Budha', 'Konghuchu', 'Lainnya'] as $agamaOption)
                        <option value="{{ $agamaOption }}" {{ old('agama') == $agamaOption ? 'selected' : '' }}>{{ $agamaOption }}</option>
                    @endforeach
                </select>
                @error('agama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="form-label">Jumlah Saudara <sup class="text-danger">*</sup></label>
                <input type="number" class="form-control @error('saudara') is-invalid @enderror" placeholder="Jumlah Saudara" {{ $inputAttr }} name="saudara" value="{{ old('saudara') }}">
                @error('saudara')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Anak Ke <sup class="text-danger">*</sup></label>
                <input type="number" class="form-control @error('anak_ke') is-invalid @enderror" placeholder="Anak Ke" {{ $inputAttr }} name="anak_ke" value="{{ old('anak_ke') }}">
                @error('anak_ke')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- DATA NILAI -->
            <div class="col-md-12 mt-4">
                <h3>Data Nilai</h3>
            </div>

            @for ($i = 1; $i <= 6; $i++)
                <div class="col-md-6 mt-3">
                    <label class="form-label">Semester {{ $i }} <sup class="text-danger">*</sup></label>
                    <input type="number" step="0.01" class="form-control @error('smt'.$i) is-invalid @enderror" placeholder="Rata-rata Nilai Semester {{ $i }}" {{ $inputAttr }} name="smt{{ $i }}" value="{{ old('smt'.$i) }}">
                    @error('smt'.$i)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endfor

            <div class="col-md-12 mt-3">
                <label class="form-label">Ujian Sekolah (US) / Ujian Madrasah (UM) <sup class="text-danger">*</sup></label>
                <input type="number" step="0.01" class="form-control @error('us') is-invalid @enderror" placeholder="Rata-rata Nilai Ujian Sekolah" {{ $inputAttr }} name="us" value="{{ old('us') }}">
                @error('us')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- DATA ORANG TUA -->
            <div class="col-md-12 mt-4">
                <h3>Data Orang Tua</h3>
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Nama Ayah <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" placeholder="Nama Ayah" {{ $inputAttr }} name="nama_ayah" value="{{ old('nama_ayah') }}">
                @error('nama_ayah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Nama Ibu <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" placeholder="Nama Ibu" {{ $inputAttr }} name="nama_ibu" value="{{ old('nama_ibu') }}">
                @error('nama_ibu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Status Ayah <sup class="text-danger">*</sup></label>
                <select class="form-select @error('status_ayah') is-invalid @enderror" {{ $inputAttr }} name="status_ayah">
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
                <select class="form-select @error('status_ibu') is-invalid @enderror" {{ $inputAttr }} name="status_ibu">
                    <option disabled selected value="">Pilih Status</option>
                    <option value="Masih Ada" {{ old('status_ibu') == 'Masih Ada' ? 'selected' : '' }}>Masih Ada</option>
                    <option value="Tidak Ada" {{ old('status_ibu') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                </select>
                @error('status_ibu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Pekerjaan Ayah <sup class="text-danger">*</sup></label>
                <select class="form-select @error('pekerjaan_ayah') is-invalid @enderror" {{ $inputAttr }} name="pekerjaan_ayah">
                    <option disabled selected value="">Pilih Pekerjaan</option>
                    @foreach($pekerjaanList as $pekerjaan)
                        <option value="{{ $pekerjaan }}" {{ old('pekerjaan_ayah') == $pekerjaan ? 'selected' : '' }}>
                            {{ $pekerjaan }}
                        </option>
                    @endforeach
                </select>
                @error('pekerjaan_ayah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Pekerjaan Ibu <sup class="text-danger">*</sup></label>
                <select class="form-select @error('pekerjaan_ibu') is-invalid @enderror" {{ $inputAttr }} name="pekerjaan_ibu">
                    <option disabled selected value="">Pilih Pekerjaan</option>
                    @foreach($pekerjaanList as $pekerjaan)
                        <option value="{{ $pekerjaan }}" {{ old('pekerjaan_ibu') == $pekerjaan ? 'selected' : '' }}>
                            {{ $pekerjaan }}
                        </option>
                    @endforeach
                </select>
                @error('pekerjaan_ibu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Penghasilan Ayah <sup class="text-danger">*</sup></label>
                <input type="number" class="form-control @error('penghasilan_ayah') is-invalid @enderror" placeholder="Penghasilan Ayah (Rp)" {{ $inputAttr }} name="penghasilan_ayah" value="{{ old('penghasilan_ayah') }}">
                @error('penghasilan_ayah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Penghasilan Ibu <sup class="text-danger">*</sup></label>
                <input type="number" class="form-control @error('penghasilan_ibu') is-invalid @enderror" placeholder="Penghasilan Ibu (Rp)" {{ $inputAttr }} name="penghasilan_ibu" value="{{ old('penghasilan_ibu') }}">
                @error('penghasilan_ibu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- DATA KONTAK -->
            <div class="col-md-12 mt-4">
                <h3>Data Kontak</h3>
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Nomor HP Ayah</label>
                <input type="text" class="form-control" placeholder="Ex: 08xxxxxxxx" {{ $inputAttr }} name="hp_ayah" value="{{ old('hp_ayah') }}">
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Nomor HP Ibu</label>
                <input type="text" class="form-control" placeholder="Ex: 08xxxxxxxx" {{ $inputAttr }} name="hp_ibu" value="{{ old('hp_ibu') }}">
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Nomor HP Siswa <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('hp_siswa') is-invalid @enderror" placeholder="Ex: 08xxxxxxxx" {{ $inputAttr }} name="hp_siswa" value="{{ old('hp_siswa') }}">
                @error('hp_siswa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Alamat Email Siswa <sup class="text-danger">*</sup></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Alamat Email" {{ $inputAttr }} name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Jarak ke Sekolah <sup class="text-danger">*</sup></label>
                <div class="input-group">
                    <input type="text" readonly class="form-control @error('jarak_km') is-invalid @enderror" placeholder="Kilometer" {{ $inputAttr }} name="jarak_km" value="{{ old('jarak_km') }}">
                    <button type="button" id="pick-on-map" class="btn btn-outline-dark" {{ $inputAttr }}>Pilih dari Peta</button>
                </div>
                <small class="form-text text-muted">Klik lokasi rumah pada peta untuk menghitung jarak ke sekolah.</small>
                @error('jarak_km')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

            <div class="col-md-6 mt-3">
                <label class="form-label">Direkomendasikan oleh</label>
                <input type="text" class="form-control" placeholder="Tahu SMAN 1 Sindangkasih dari?" {{ $inputAttr }} name="rekomendasi" value="{{ old('rekomendasi') }}">
            </div>

            <div class="col-md-12 mt-3">
                <label class="form-label">Alamat <sup class="text-danger">*</sup></label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat Lengkap Beserta RT & RW" {{ $inputAttr }} name="alamat">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- DATA LAMPIRAN -->
            <div class="col-md-12 mt-4">
                <h3>Data Lampiran</h3>
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label" for="foto_profil">Foto Profil (JPG/PNG) <sup class="text-danger">*</sup></label>
                <input type="file" class="form-control @error('foto_profil') is-invalid @enderror" {{ $inputAttr }} name="foto_profil" accept="image/*">
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
                <label class="form-label" for="transkrip_nilai">Transkrip Nilai (PDF) <sup class="text-danger">*</sup></label>
                <input type="file" class="form-control @error('transkrip_nilai') is-invalid @enderror" {{ $inputAttr }} name="transkrip_nilai" accept="application/pdf">
                @if(isset($pendaftar) && $pendaftar->transkrip_nilai)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $pendaftar->transkrip_nilai) }}" target="_blank" class="btn btn-sm btn-primary">
                            Lihat Transkrip Nilai
                        </a>
                    </div>
                @endif
                @error('transkrip_nilai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label" for="skhun">Ujian Sekolah (PDF) <sup class="text-danger">*</sup></label>
                <input type="file" class="form-control @error('skhun') is-invalid @enderror" {{ $inputAttr }} name="skhun" accept="application/pdf">
                @if(isset($pendaftar) && $pendaftar->skhun)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $pendaftar->skhun) }}" target="_blank" class="btn btn-sm btn-primary">
                            Lihat SKHUN / Ujian Sekolah
                        </a>
                    </div>
                @endif
                @error('skhun')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label" for="sktm">Slip Gaji / SKTM (PDF/JPG) <sup class="text-danger">*</sup></label>
                <input type="file" class="form-control @error('sktm') is-invalid @enderror" {{ $inputAttr }} name="sktm" accept="application/pdf,image/*">
                @if(isset($pendaftar) && $pendaftar->sktm)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $pendaftar->sktm) }}" target="_blank" class="btn btn-sm btn-primary">
                            Lihat SKTM
                        </a>
                    </div>
                @endif
                @error('sktm')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label" for="kartu_keluarga">Kartu Keluarga (PDF) <sup class="text-danger">*</sup></label>
                <input type="file" class="form-control @error('kartu_keluarga') is-invalid @enderror" {{ $inputAttr }} name="kartu_keluarga" accept="application/pdf">
                @if(isset($pendaftar) && $pendaftar->kartu_keluarga)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $pendaftar->kartu_keluarga) }}" target="_blank" class="btn btn-sm btn-primary">
                            Lihat Kartu Keluarga
                        </a>
                    </div>
                @endif
                @error('kartu_keluarga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label" for="sptjm">Surat Pernyataan Tanggung Jawab Mutlak (SPTJM) <sup class="text-danger">*</sup></label>
                <input type="file" class="form-control @error('sptjm') is-invalid @enderror" {{ $inputAttr }} name="sptjm" accept="application/pdf" required>
                <small class="form-text text-muted">Cetak blanko SPTJM, tanda tangani pendaftar dan orang tua/wali, kemudian unggah PDF maksimal 5 MB.</small>
                <div class="mt-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#sptjmModal">Baca ketentuan SPTJM</button>
                </div>
                @error('sptjm')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- TOMBOL SUBMIT -->
            <div class="col-md-12 mt-4">
                @if($isBuka)
                    <button type="submit" class="btn btn-outline-success w-100">Kirim Datamu!</button>
                @else
                    <button type="button" class="btn btn-outline-danger w-100" disabled>Belum Dibuka!</button>
                @endif
            </div>
        </div>
    </form>
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

<!-- Map Picker Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">Pilih Lokasi Rumah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="map" style="height:500px; width:100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirm-location" class="btn btn-primary" data-bs-dismiss="modal">Pilih Lokasi</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>