@extends('layouts.dashboard.app')
@section('content')
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="main-content">
        <section class="section">
        <!-- MAIN OF CENTER CONTENT -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title fw-semibold mb-4">Data Pendaftar</h5>
                    <table class="table table-borderless">
                      <tr>
                          <td>Gelombang</td>
                          <td>:</td>
                          <td>{{$data->gelombang}}</td>
                      </tr>
                      <tr>
                          <td>Jurusan Diambil</td>
                          <td>:</td>
                          <td>{{$data->jurusan}}</td>
                      </tr>
                      <tr>
                          <td>Jalur</td>
                          <td>:</td>
                          <td>{{$data->jalur}}</td>
                      </tr>
                      <tr>
                          <td>Nama Lengkap</td>
                          <td>:</td>
                          <td>{{$data->nama_siswa}}</td>
                      </tr>
                      <tr>
                          <td>Asal Sekolah</td>
                          <td>:</td>
                          <td>{{$data->asal_sekolah}}</td>
                      </tr>
                      <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td>{{$data->nik ?? '-'}}</td>
                      </tr>
                      <tr>
                        <td>NISN</td>
                        <td>:</td>
                        <td>{{$data->nisn ?? '-'}}</td>
                      </tr>
                      <tr>
                          <td>Tempat Tanggal Lahir</td>
                          <td>:</td>
                          <td>{{$data->tempat_lahir}}, {{$data->tanggal_lahir}}</td>
                      </tr>
                      <tr>
                          <td>Agama</td>
                          <td>:</td>
                          <td>{{$data->agama}}</td>
                      </tr>
                      <tr>
                          <td>Jenis Kelamin</td>
                          <td>:</td>
                          <td>{{$data->jenis_kelamin}}</td>
                      </tr> 
                      <tr>
                          <td>Jumlah Saudara</td>
                          <td>:</td>
                          <td>{{$data->saudara}}</td>
                      </tr>
                      <tr>
                          <td>Anak Ke</td>
                          <td>:</td>
                          <td>{{$data->anak_ke}}</td>
                      </tr>
                    </table>
                </div>
              </div>
            </div>
            
          </div>
        <!-- END OF CENTER CONTENT -->
        </section>


        <section class="section">
        <!-- MAIN OF CENTER CONTENT -->
        <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title fw-semibold mb-4">Data Nilai</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td>Semester 1</td>
                            <td>:</td>
                            <td>{{$data->smt1 ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Semester 2</td>
                            <td>:</td>
                            <td>{{$data->smt2 ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Semester 3</td>
                            <td>:</td>
                            <td>{{$data->smt3 ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Semester 4</td>
                            <td>:</td>
                            <td>{{$data->smt4 ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Semester 5</td>
                            <td>:</td>
                            <td>{{$data->smt5 ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Semester 6</td>
                            <td>:</td>
                            <td>{{$data->smt6 ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Ujian Sekolah</td>
                            <td>:</td>
                            <td>{{$data->us ?? '-'}}</td>
                        </tr>
                    </table>
                </div>
              </div>
            </div>
          </div>
        <!-- END OF CENTER CONTENT -->


        </section>

        <section class="section">
        <!-- MAIN OF CENTER CONTENT -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title fw-semibold mb-4">Data Orang Tua</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td>Nama Ayah</td>
                            <td>:</td>
                            <td>{{$data->nama_ayah ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Status Ayah</td>
                            <td>:</td>
                            <td>{{$data->status_ayah ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Pekerjaan Ayah</td>
                            <td>:</td>
                            <td>{{$data->pekerjaan_ayah ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Penghasilan Ayah</td>
                            <td>:</td>
                            <td>{{$data->penghasilan_ayah ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Nama Ibu</td>
                            <td>:</td>
                            <td>{{$data->nama_ibu ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Status Ibu</td>
                            <td>:</td>
                            <td>{{$data->status_ibu ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Pekerjaan ibu</td>
                            <td>:</td>
                            <td>{{$data->pekerjaan_ibu ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Penghasilan ibu</td>
                            <td>:</td>
                            <td>{{$data->penghasilan_ibu ?? '-'}}</td>
                        </tr>
                    </table>
                </div>
              </div>
            </div>
            
          </div>
        <!-- END OF CENTER CONTENT -->
        </section>


        <section class="section">
        <!-- MAIN OF CENTER CONTENT -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title fw-semibold mb-4">Data Kontak</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td>HP Ayah</td>
                            <td>:</td>
                            <td>{{$data->hp_ayah ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>HP Ibu</td>
                            <td>:</td>
                            <td>{{$data->hp_ibu ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>HP Siswa</td>
                            <td>:</td>
                            <td>{{$data->hp_siswa ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Email Siswa</td>
                            <td>:</td>
                            <td>{{$data->email ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Jarak Ke Sekolah</td>
                            <td>:</td>
                            <td>{{$data->jarak ?? '-'}} KM</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{$data->alamat ?? '-'}}</td>
                        </tr>
                        
                    </table>
                </div>
              </div>
            </div>
          </div>
        <!-- END OF CENTER CONTENT -->

        </section>
        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title fw-semibold mb-4">Data Berkas Pendaftar</h5>
                  <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td class="fw-bold">Foto Profil</td>
                        <td>:</td>
                        <td>
                          @if(isset($data->foto_profil))
                            <img src="{{ asset('storage/' . $data->foto_profil) }}" alt="Foto Profil" class="img-thumbnail" width="200">
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td class="fw-bold">Transkrip Nilai</td>
                        <td>:</td>
                        <td>
                          @if(isset($data->transkrip_nilai))
                            <a href="{{ asset('storage/' . $data->transkrip_nilai) }}" target="_blank" class="btn btn-sm btn-primary">Lihat Transkrip Nilai</a>
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td class="fw-bold">SKHUN</td>
                        <td>:</td>
                        <td>
                          @if(isset($data->skhun))
                            <a href="{{ asset('storage/' . $data->skhun) }}" target="_blank" class="btn btn-sm btn-primary">Lihat SKHUN</a>
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td class="fw-bold">Kartu Keluarga</td>
                        <td>:</td>
                        <td>
                          @if(isset($data->kartu_keluarga))
                            <a href="{{ asset('storage/' . $data->kartu_keluarga) }}" target="_blank" class="btn btn-sm btn-primary">Lihat Kartu Keluarga</a>
                          @else
                            <span class="text-muted">-</span>
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