<div class="container-xxl py-5 text-dark">
    <div class="container">
        <div class="text-center mx-auto" style="max-width: 500px">
            <h1 class="display-6 mb-5">
            Formulir Pendaftaran Online SMAN 1 SINDANGKASIH
            </h1>
        </div>
            <div class="row g-4 justify-content-center">
            <form action="{{route('yes_daftar')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="col-md-12">
                <h3>Data Gelombang dan Jurusan</h3>
            </div>
            <div class="col-md-6 mt-3">
                <label>Gelombang</label>
                <input type="text" value="{{ $gelombang->gelombang ?? 'Belum Ada Gelombang' }} " name="gelombang"
                    class="form-control disabl" readonly>
            </div>
            <div class="col-md-6 mt-3">
                <label>Status Gelombang</label>
                <input type="text" value="{{$gelombang->status_gelombang ?? 'Belum Di Buka'}}"
                    class="form-control" disabled>
            </div>
            <div class="col-md-6 mt-3">
                <label>Jurusan Yang Di Ambil <sup class="text-danger">*</sup></label>
                <select {{$form}} @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="jurusan" @endif class="form-control @error('jurusan') is-invalid @enderror">
                    <option disabled selected value>Pilih Jurusan</option>
                    @foreach($jurusan as $jr)
                    <option value="{{$jr->jurusan}}" {{ old('jurusan') == $jr->jurusan ? 'selected' : '' }}>{{$jr->jurusan}}</option>
                    @endforeach
                </select>
                @error('jurusan')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label>Jalur Pendaftaran Yang Di Ambil <sup class="text-danger">*</sup></label>
                <select {{$form}} @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="jalur" @endif class="form-control @error('jalur') is-invalid @enderror">
                    <option disabled selected value>Pilih Jalur</option>
                    @foreach($jalur as $jl)
                    <option value="{{$jl->jalur}}" {{ old('jalur') == $jl->jalur ? 'selected' : '' }}>{{$jl->jalur}}</option>
                    @endforeach
                </select>
                @error('jalur')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="col-md-12 mt-3">
                <h3>Data Pendaftar</h3>
            </div>
            <div class="col-md-6 mt-3">
                <label>Nama Lengkap Siswa <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror"
                    placeholder="Nama Siswa" {{$form}} @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="nama_siswa" @endif value="{{old('nama_siswa')}}">
                @error('nama_siswa')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Asal Sekolah <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror"
                    placeholder="Asal Sekolah SMP" {{$form}} @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="asal_sekolah" @endif value="{{old('asal_sekolah')}}">
                @error('asal_sekolah')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3"> 
                <label>Nomor Induk Kependudukan (NIK)<sup class="text-danger">*</sup></label>
                <input type="number" maxlength="16"
                    class="form-control @error('nik') is-invalid @enderror" placeholder="NIK Ada Di KK" {{$form}} @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="nik" @endif 
                    value="{{ old('nik') }}">
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mt-3">
                <label>Nomor Induk Siswa Nasional (NISN)<sup class="text-danger">*</sup></label>
                <input type="number" maxlength="10" 
                    class="form-control @error('nisn') is-invalid @enderror" placeholder="NISN" {{$form}} @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="nisn" @endif 
                    value="{{old('nisn')}}">
                @error('nisn')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Tempat Lahir <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                    placeholder="Tempat Lahir Siswa" {{$form}} @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="tempat_lahir" @endif value="{{old('tempat_lahir')}}">
                @error('tempat_lahir')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Tanggal Lahir <sup class="text-danger">*</sup></label>
                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                    placeholder="Tanggal Lahir Siswa" {{$form}} @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="tanggal_lahir" @endif value="{{old('tanggal_lahir')}}">
                @error('tanggal_lahir')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Jenis Kelamin<sup class="text-danger">*</sup></label>
                <select class="form-control @error('jenis_kelamin') is-invalid @enderror" {{$form}}
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="jenis_kelamin" @endif>
                    <option disabled selected value>Pilih Jenis Kelamin</option>
                    <option value="Laki Laki" {{ old('jenis_kelamin') == 'Laki Laki' ? 'selected' : ''}}>Laki Laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : ''}}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Agama <sup class="text-danger">*</sup></label>
                <select class="form-control @error('agama') is-invalid @enderror" {{$form}}
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="agama" @endif>
                    <option disabled selected value>Pilih Agama</option>
                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : ''}}>Islam</option>
                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : ''}}>Kristen</option>
                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : ''}}>Hindu</option>
                    <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : ''}}>Budha</option>
                    <option value="Konghuchu" {{ old('agama') == 'Konghuchu' ? 'selected' : ''}}>Konghuchu</option>
                    <option value="Lainnya" {{ old('agama') == 'Lainnya' ? 'selected' : ''}}>Lainnya</option>
                </select>
                @error('agama')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Jumlah Saudara<sup class="text-danger">*</sup></label>
                <input type="number" class="form-control @error('saudara') is-invalid @enderror" placeholder="Jumlah Saudara" {{$form}} 
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="saudara" @endif value="{{old('saudara')}}">
                @error('saudara')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label>Anak Ke<sup class="text-danger">*</sup></label>
                <input type="number" class="form-control @error('anak_ke') is-invalid @enderror" placeholder="Anak Ke" {{$form}} 
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="anak_ke" @endif value="{{old('anak_ke')}}">
                @error('anak_ke')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="col-md-12 mt-3">
                <h3>Data Nilai</h3>
            </div>

            @for ($i = 1; $i <= 6; $i++)
            <div class="col-md-6 mt-3">
                <label>Semester {{$i}}<sup class="text-danger">*</sup></label>
                <input type="number" class="form-control @error('smt'.$i) is-invalid @enderror" placeholder="Rata-rata Nilai Semester {{$i}}" {{$form}} 
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="smt{{$i}}" @endif value="{{ old('smt'.$i) }}">
                @error('smt'.$i)
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            @endfor
            <div class="col-md-12 mt-3">
                <label>Ujian Sekolah(US)/Ujian Madrasah(UM)<sup class="text-danger">*</sup></label>
                <input type="number" class="form-control @error('us') is-invalid @enderror" placeholder="Rata-rata Nilai Ujian Sekolah" {{$form}} 
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="us" @endif value="{{old('us')}}">
                @error('us')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-12 mt-3">
                <h3>Data Orang Tua</h3>
            </div>
            <div class="col-md-6 mt-3">
                <label>Nama Ayah<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror"
                    placeholder="Nama Ayah" {{$form}} @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="nama_ayah" @endif value="{{old('nama_ayah')}}">
                @error('nama_ayah')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Nama Ibu<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                    placeholder="Nama Ibu" {{$form}} @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="nama_ibu" @endif value="{{old('nama_ibu')}}">
                @error('nama_ibu')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Status Ayah<sup class="text-danger">*</sup></label>
                <select class="form-control @error('status_ayah') is-invalid @enderror" {{$form}}
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="status_ayah" @endif">
                    <option disabled selected value>Pilih Status</option>
                    <option value="Masih Ada" {{ old('status_ayah') == 'Masih Ada' ? 'selected' : ''}}>Masih Ada</option>
                    <option value="Tidak Ada" {{ old('status_ayah') == 'Tidak Ada' ? 'selected' : ''}}>Tidak Ada</option>
                </select>
                @error('status_ayah')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Status Ibu<sup class="text-danger">*</sup></label>
                <select class="form-control @error('status_ibu') is-invalid @enderror" {{$form}}
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="status_ibu" @endif>
                    <option disabled selected value>Pilih Status</option>
                    <option value="Masih Ada" {{ old('status_ibu') == 'Masih Ada' ? 'selected' : ''}}>Masih Ada</option>
                    <option value="Tidak Ada" {{ old('status_ibu') == 'Tidak Ada' ? 'selected' : ''}}>Tidak Ada</option>
                </select>
                @error('status_ibu')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Pekerjaan Ayah<sup class="text-danger">*</sup></label>
                <select class="form-control @error('pekerjaan_ayah') is-invalid @enderror" {!! $form !!}
                    @if($gelombang && $gelombang->status_gelombang == 'Buka') name="pekerjaan_ayah" @endif>
                    <option disabled selected value>Pilih Pekerjaan</option>
                    @php
                        $pekerjaan_list = [
                            "Tidak Bekerja", "Nelayan", "Petani", "Peternak", "Guru",
                            "PNS/TNI/POLRI", "Karyawan Swasta", "Pedagang Kecil", "Pedagang Besar",
                            "Wiraswasta", "Wirausaha", "Buruh", "Pensiunan", "Lain-lain"
                        ];
                    @endphp
                    @foreach($pekerjaan_list as $pekerjaan)
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
                <label>Pekerjaan Ibu<sup class="text-danger">*</sup></label>
                <select class="form-control @error('pekerjaan_ibu') is-invalid @enderror" {!! $form !!}
                    @if($gelombang && $gelombang->status_gelombang == 'Buka') name="pekerjaan_ibu" @endif>
                    <option disabled selected value>Pilih Pekerjaan</option>
                    @foreach($pekerjaan_list as $pekerjaan)
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
                <label>Penghasilan Ayah<sup class="text-danger">*</sup></label>
                <select class="form-control @error('penghasilan_ayah') is-invalid @enderror" {!! $form !!}
                    @if($gelombang && $gelombang->status_gelombang == 'Buka') name="penghasilan_ayah" @endif>
                    <option disabled selected value>Pilih Penghasilan</option>
                    @php
                        $penghasilan_list = [
                            "< 1 juta", "1-3 juta", "3-5 juta", "5-10 juta", "> 10 juta"
                        ];
                    @endphp
                    @foreach($penghasilan_list as $penghasilan)
                        <option value="{{ $penghasilan }}" {{ old('penghasilan_ayah') == $penghasilan ? 'selected' : '' }}>
                            {{ $penghasilan }}
                        </option>
                    @endforeach
                </select>
                @error('penghasilan_ayah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label>Penghasilan Ibu<sup class="text-danger">*</sup></label>
                <select class="form-control @error('penghasilan_ibu') is-invalid @enderror" {!! $form !!}
                    @if($gelombang && $gelombang->status_gelombang == 'Buka') name="penghasilan_ibu" @endif>
                    <option disabled selected value>Pilih Penghasilan</option>
                    @foreach($penghasilan_list as $penghasilan)
                        <option value="{{ $penghasilan }}" {{ old('penghasilan_ibu') == $penghasilan ? 'selected' : '' }}>
                            {{ $penghasilan }}
                        </option>
                    @endforeach
                </select>
                @error('penghasilan_ibu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 mt-3">
                <h3>Data Kontak</h3>
            </div>
            <div class="col-md-6 mt-3">
                <label>Nomor HP Ayah</label>
                <input type="text" class="form-control" placeholder="Ex: 08xxxxxxxx" {{$form}}
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="hp_ayah" @endif value="{{old('hp_ayah')}}">
            </div>
            <div class="col-md-6 mt-3">
                <label>Nomor HP Ibu</label>
                <input type="text" class="form-control" placeholder="Ex: 08xxxxxxxx" {{$form}}
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="hp_ibu" @endif value="{{old('hp_ibu')}}">
            </div>
            <div class="col-md-6 mt-3">
                <label>Nomor HP Siswa<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('hp_siswa') is-invalid @enderror" placeholder="Ex: 08xxxxxxxx" {{$form}}
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="hp_siswa" @endif value="{{old('hp_siswa')}}">
                @error('hp_siswa')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Alamat Email Siswa<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Alamat Email" {{$form}}
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="email" @endif value="{{old('email')}}">
                @error('email')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Jarak ke Sekolah<sup class="text-danger">*</sup></label>
                <input type="number" class="form-control @error('jarak') is-invalid @enderror" placeholder="Satuan KM" {{$form}}
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="jarak" @endif value="{{old('jarak')}}">
                @error('jarak')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label>Direkomendasikan oleh</label>
                <input type="text" class="form-control" placeholder="Rekomendasi Masuk SMAN 1 Sindangkasih oleh" {{$form}}
                    @if($gelombang==null) @elseif($gelombang->status_gelombang == 'Buka') name="rekomendasi" @endif value="{{old('rekomendasi')}}">
            </div>
            <div class="col-md-12 mt-3">
                <label>Alamat<sup class="text-danger">*</sup></label>
                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                    placeholder="Alamat Lengkap Beserta RT & RW" {{$form}} 
                    @if($gelombang==null) 
                    @elseif($gelombang->status_gelombang == 'Buka') name="alamat" @endif>{{ old('alamat') }}</textarea>
                @error('alamat')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="col-md-12 mt-3">
                <h3>Data Lampiran</h3>
            </div>
            <div class="col-md-6 mt-3">
                <label for="foto_profil">Foto Profil (JPG/PNG)<sup class="text-danger">*</sup></label>
                <input type="file" class="form-control @error('foto_profil') is-invalid @enderror"{{$form}}
                    @if($gelombang==null) 
                    @elseif($gelombang->status_gelombang == 'Buka') name="foto_profil"
                    @endif accept="image/*">
    
                @if(isset($pendaftar) && $pendaftar->foto_profil)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $pendaftar->foto_profil) }}" alt="Foto Profil" class="img-thumbnail" width="150">
                </div>
                @endif
    
                @error('foto_profil')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
    
            <div class="col-md-6 mt-3">
                <label for="transkrip_nilai">Transkrip Nilai (PDF)<sup class="text-danger">*</sup></label>
                <input type="file" class="form-control @error('transkrip_nilai') is-invalid @enderror" {{$form}}
                    @if($gelombang==null) 
                    @elseif($gelombang->status_gelombang == 'Buka') name="transkrip_nilai"
                    @endif accept="application/pdf">
                
                @if(isset($pendaftar) && $pendaftar->transkrip_nilai)
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $pendaftar->transkrip_nilai) }}" target="_blank" class="btn btn-sm btn-primary">
                        Lihat Transkrip Nilai
                    </a>
                </div>
                @endif
    
                @error('transkrip_nilai')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
            <div class="col-md-6 mt-3">
                <label for="skhun">Ujuan Sekolah (PDF)<sup class="text-danger">*</sup></label>
                <input type="file" class="form-control @error('skhun') is-invalid @enderror" {{$form}}
                    @if($gelombang==null) 
                    @elseif($gelombang->status_gelombang == 'Buka') name="skhun"
                    @endif accept="application/pdf">
                
                @if(isset($pendaftar) && $pendaftar->skhun)
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $pendaftar->skhun) }}" target="_blank" class="btn btn-sm btn-primary">
                        Lihat SKHUN
                    </a>
                </div>
                @endif
    
                @error('skhun')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
            <div class="col-md-6 mt-3">
                <label for="kartu_keluarga">Kartu Keluarga (PDF)<sup class="text-danger">*</sup></label>
                <input type="file" class="form-control @error('kartu_keluarga') is-invalid @enderror" {{$form}}
                    @if($gelombang==null) 
                    @elseif($gelombang->status_gelombang == 'Buka') name="kartu_keluarga"
                    @endif accept="application/pdf">
                
                @if(isset($pendaftar) && $pendaftar->kartu_keluarga)
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $pendaftar->kartu_keluarga) }}" target="_blank" class="btn btn-sm btn-primary">
                        Lihat Kartu Keluarga
                    </a>
                </div>
                @endif
    
                @error('kartu_keluarga')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

                    <div class="col-md-12 mt-3">
                        <input {{$form}} @if($gelombang==null) class="btn btn-outline-danger btn-block"
                            value="Belum Di Buka!" @elseif($gelombang->status_gelombang == 'Buka') class="btn
                        btn-outline-success btn-block" value="Kirim Datamu!" type="submit" @endif>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Halo Guys</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    Selamat Datang Di Web PPDB SMAN 1 Sindangkasih 2025 / 2026, ada beberapa aturan sebelum mengisi
                    form pengisian di bawah ini, seperti
                </p>
                <ul>
                    <li>Isikan data dengan benar sesuai yang ada pada Kartu Keluarga</li>
                    <li>Perhatikan Status Gelombang Apakah Buka Atau Tutup</li>
                    <li>Perhatikan Tanda ( <span class="badge bg-danger">*</span> ), Jika ada tanda tersebut wajib
                        diisi, jika tidak diisi maka pendaftaran anda gagal</li>
                    <li>Sebelum mendaftar cek terlebih dahulu apakah data anda sudah ada atau belum pada link <a
                            href="{{url('/cek')}}"> <span class="badge bg-success">Disini</span></a></li>
                    <li>Jika sudah mengisi silahkan cek data anda di link <a href="{{url('/cek')}}"> <span
                                class="badge bg-success">Disini</span></a></li>
                    <li>Usahakan data rekomendasi terisi, agar kami lebih mudah ketika mengecek data anda</li>

                </ul>
                <p>
                    Terima kasih telah mendaftar di SMAN 1 Sindangkasih
                </p>
                <p>
                    Jangan lupa cek datamu ya !
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>