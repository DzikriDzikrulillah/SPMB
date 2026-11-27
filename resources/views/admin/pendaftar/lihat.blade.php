@extends('layouts.dashboard.app')

@section('content')
<div id="app">
  <div class="main-wrapper main-wrapper-1">
    <div class="main-content">

      <!-- SECTION 1: DATA PENDAFTAR -->
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Data Pendaftar</h5>
                <table class="table table-borderless align-middle">
                  <tbody>
                    <tr>
                      <td style="width: 200px;">Gelombang</td>
                      <td style="width: 10px;">:</td>
                      <td>{{ $data->gelombang ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Jurusan Diambil</td>
                      <td>:</td>
                      <td>{{ $data->jurusan ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Jalur</td>
                      <td>:</td>
                      <td>{{ $data->jalur ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Nama Lengkap</td>
                      <td>:</td>
                      <td>{{ $data->nama_siswa ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Asal Sekolah</td>
                      <td>:</td>
                      <td>{{ $data->asal_sekolah ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>NIK</td>
                      <td>:</td>
                      <td>{{ $data->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>NISN</td>
                      <td>:</td>
                      <td>{{ $data->nisn ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Tempat Tanggal Lahir</td>
                      <td>:</td>
                      <td>
                        @if(!empty($data->tempat_lahir) || !empty($data->tanggal_lahir))
                          {{ $data->tempat_lahir ?? '-' }}, {{ $data->tanggal_lahir ?? '-' }}
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Agama</td>
                      <td>:</td>
                      <td>{{ $data->agama ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Jenis Kelamin</td>
                      <td>:</td>
                      <td>{{ $data->jenis_kelamin ?? '-' }}</td>
                    </tr> 
                    <tr>
                      <td>Jumlah Saudara</td>
                      <td>:</td>
                      <td>{{ $data->saudara ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Anak Ke</td>
                      <td>:</td>
                      <td>{{ $data->anak_ke ?? '-' }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- SECTION 2: DATA NILAI -->
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Data Nilai</h5>
                <table class="table table-borderless align-middle">
                  <tbody>
                    <tr>
                      <td style="width: 200px;">Semester 1</td>
                      <td style="width: 10px;">:</td>
                      <td>{{ $data->smt1 ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Semester 2</td>
                      <td>:</td>
                      <td>{{ $data->smt2 ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Semester 3</td>
                      <td>:</td>
                      <td>{{ $data->smt3 ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Semester 4</td>
                      <td>:</td>
                      <td>{{ $data->smt4 ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Semester 5</td>
                      <td>:</td>
                      <td>{{ $data->smt5 ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Semester 6</td>
                      <td>:</td>
                      <td>{{ $data->smt6 ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Ujian Sekolah</td>
                      <td>:</td>
                      <td>{{ $data->us ?? '-' }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- SECTION 3: DATA ORANG TUA -->
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Data Orang Tua</h5>
                <table class="table table-borderless align-middle">
                  <tbody>
                    <tr>
                      <td style="width: 200px;">Nama Ayah</td>
                      <td style="width: 10px;">:</td>
                      <td>{{ $data->nama_ayah ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Status Ayah</td>
                      <td>:</td>
                      <td>{{ $data->status_ayah ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Pekerjaan Ayah</td>
                      <td>:</td>
                      <td>{{ $data->pekerjaan_ayah ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Penghasilan Ayah</td>
                      <td>:</td>
                      <td>{{ $data->penghasilan_ayah ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Nama Ibu</td>
                      <td>:</td>
                      <td>{{ $data->nama_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Status Ibu</td>
                      <td>:</td>
                      <td>{{ $data->status_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Pekerjaan Ibu</td>
                      <td>:</td>
                      <td>{{ $data->pekerjaan_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Penghasilan Ibu</td>
                      <td>:</td>
                      <td>{{ $data->penghasilan_ibu ?? '-' }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- SECTION 4: DATA KONTAK -->
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Data Kontak</h5>
                <table class="table table-borderless align-middle">
                  <tbody>
                    <tr>
                      <td style="width: 200px;">HP Ayah</td>
                      <td style="width: 10px;">:</td>
                      <td>{{ $data->hp_ayah ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>HP Ibu</td>
                      <td>:</td>
                      <td>{{ $data->hp_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>HP Siswa</td>
                      <td>:</td>
                      <td>{{ $data->hp_siswa ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Email Siswa</td>
                      <td>:</td>
                      <td>{{ $data->email ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Jarak Ke Sekolah</td>
                      <td>:</td>
                      <td>{{ isset($data->jarak_km) ? $data->jarak_km . ' KM' : '-' }}</td>
                    </tr>
                    <tr>
                      <td>Alamat</td>
                      <td>:</td>
                      <td>{{ $data->alamat ?? '-' }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- SECTION 5: DATA BERKAS -->
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Data Berkas Pendaftar</h5>
                <table class="table table-borderless align-middle">
                  <tbody>
                    <tr>
                      <td class="fw-bold" style="width: 200px;">Foto Profil</td>
                      <td style="width: 10px;">:</td>
                      <td>
                        @if(!empty($data->foto_profil))
                          <div class="d-flex align-items-center gap-3">
                            <img src="{{ Storage::url($data->foto_profil) }}" alt="Foto Profil" class="img-thumbnail" width="150" height="150" style="object-fit: cover;">
                            <a href="{{ Storage::url($data->foto_profil) }}" target="_blank" class="btn btn-sm btn-primary">
                              <i class="bi bi-eye"></i> Lihat Foto
                            </a>
                          </div>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td class="fw-bold">Transkrip Nilai</td>
                      <td>:</td>
                      <td>
                        @if(!empty($data->transkrip_nilai))
                          <a href="{{ Storage::url($data->transkrip_nilai) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="bi bi-file-earmark-pdf"></i> Lihat Transkrip Nilai
                          </a>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td class="fw-bold">SKHUN</td>
                      <td>:</td>
                      <td>
                        @if(!empty($data->skhun))
                          <a href="{{ Storage::url($data->skhun) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="bi bi-file-earmark-pdf"></i> Lihat SKHUN
                          </a>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td class="fw-bold">Slip Gaji / SKTM</td>
                      <td>:</td>
                      <td>
                        @if(!empty($data->sktm))
                          @if(str_ends_with(strtolower($data->sktm), '.pdf'))
                            <a href="{{ Storage::url($data->sktm) }}" target="_blank" class="btn btn-sm btn-primary">
                              <i class="bi bi-file-earmark-pdf"></i> Lihat Dokumen
                            </a>
                          @else
                            <div class="d-flex align-items-center gap-3">
                              <img src="{{ Storage::url($data->sktm) }}" alt="Slip Gaji/SKTM" class="img-thumbnail" width="150" height="150" style="object-fit: cover;">
                              <a href="{{ Storage::url($data->sktm) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Lihat Dokumen
                              </a>
                            </div>
                          @endif
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td class="fw-bold">Kartu Keluarga</td>
                      <td>:</td>
                      <td>
                        @if(!empty($data->kartu_keluarga))
                          <a href="{{ Storage::url($data->kartu_keluarga) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="bi bi-file-earmark-pdf"></i> Lihat Kartu Keluarga
                          </a>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td class="fw-bold">SPTJM</td>
                      <td>:</td>
                      <td>
                        @if(!empty($data->sptjm))
                          <a href="{{ Storage::url($data->sptjm) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="bi bi-file-earmark-pdf"></i> Lihat SPTJM
                          </a>
                        @else
                          <span class="text-muted">Belum diunggah</span>
                        @endif
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>
  </div>
</div>
@endsection