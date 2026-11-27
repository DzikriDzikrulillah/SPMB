@extends('layouts.dashboard.app')
@section('content')
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="main-content">
            <section class="section">
                <!-- MAIN OF CENTER CONTENT -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Form ACC Masal -->
                                    <div class="col-lg-4">
                                        <form action="{{ route('acc_massal') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="gelombang" class="form-label">Acc Massal</label>
                                                <select name="gelombang" class="form-select" id="gelombang">
                                                    <option disabled selected value>Pilih Gelombang</option>
                                                    <option value="Gelombang_1">1</option>
                                                    <option value="Gelombang_2">2</option>
                                                    <option value="Gelombang_3">3</option>
                                                    <option value="Gelombang_4">4</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                                        </form>
                                    </div>
                        
                                    <!-- Form Sorting -->
                                    <div class="col-lg-4">
                                        <form method="GET" action="{{ url()->current() }}">
                                            <label for="sort_by" class="form-label">Sort By</label>
                                            <select name="sort_by" class="form-select" id="sort_by" onchange="this.form.submit()">
                                                <option value="">Pilih Opsi</option>
                                                <option value="nilai" {{ request('sort_by') == 'nilai' ? 'selected' : '' }}>Nilai Terbesar</option>
                                                <option value="jarak" {{ request('sort_by') == 'jarak' ? 'selected' : '' }}>Jarak Terdekat</option>
                                            </select>
                                        </form>
                                    </div>
                        
                                    <!-- Export Excel -->
                                    <div class="col-lg-4">
                                        <label for="export" class="mb-2 form-label">Export</label>
                                        <a href="{{ route('admin.export.pendaftar') }}" class="btn btn-success w-100">Export Excel</a>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title fw-semibold">Data Pendaftar Belum Acc</h5>                          
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-borderless" id="data_pendaftar">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>Asal Sekolah</th>
                                            <th>Gelombang</th>
                                            <th>Jarak</th>
                                            <th>Total Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = ($data_pendaftar->currentPage() - 1) * $data_pendaftar->perPage() + 1;
                                        if (request('sort_by') == 'nilai') {
                                            $sortedData = $data_pendaftar->sortByDesc('akhir');
                                        } elseif (request('sort_by') == 'jarak') {
                                            $sortedData = $data_pendaftar->sortBy('jarak');
                                        } else {
                                            $sortedData = $data_pendaftar;
                                        }
                                        @endphp
                                        @foreach($sortedData as $dp)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{$dp->nama_siswa}}</td>
                                            <td>{{$dp->asal_sekolah}}</td>
                                            <td>{{$dp->gelombang}}</td>
                                            <td>{{$dp->jarak}}KM</td>
                                            <td>{{$dp->akhir}}</td>
                                            <td>
                                                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Option
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <li><a class="dropdown-item" href="{{ route('acc', $dp->id) }}">ACC</a></li>
                                                    <li><a class="dropdown-item" target="_blank" href="{{ route('pendaftar.lihat', ['id' => $dp->id]) }}">Lihat</a>                                                    </li>
                                                    <li><a class="dropdown-item" href="{{ route('hapus_siswa', $dp->id) }}">Hapus</a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $data_pendaftar->appends(request()->query())->links() }}
                            </div>
                    </div>
                <!-- END OF CENTER CONTENT -->
            </section>
            <section class="section">
                <!-- MAIN OF CENTER CONTENT -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title fw-semibold mb-2">Data Sudah Di ACC</h5>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-borderless" id="data_acc">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>Asal Sekolah</th>
                                            <th>Gelombang</th>
                                            <th>Jarak</th>
                                            <th>Nilai</th>
                                            <th>OPTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                          $no = ($data_acc->currentPage() - 1) * $data_acc->perPage() + 1;
                                            if (request('sort_by') == 'nilai') {
                                                $sortedDataAcc = $data_acc->sortByDesc('akhir');
                                            } elseif (request('sort_by') == 'jarak') {
                                                $sortedDataAcc = $data_acc->sortBy('jarak');
                                            } else {
                                                $sortedDataAcc = $data_acc;
                                            }
                                        @endphp
                                        @foreach($sortedDataAcc as $dp)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{$dp->nama_siswa}}</td>
                                            <td>{{$dp->asal_sekolah}}</td>
                                            <td>{{$dp->gelombang}}</td>
                                            <td>{{$dp->jarak}}KM</td>
                                            <td>{{$dp->akhir}}</td>
                                            <td>
                                            <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                Option
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li><a class="dropdown-item" target="_blank" href="{{ route('pendaftar.lihat', ['id' => $dp->id]) }}">Lihat</a> 
                                                <li><a class="dropdown-item" href="{{ route('hapus_siswa', $dp->id) }}">Hapus</a></li>
                                            </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $data_acc->appends(request()->query())->links() }}
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
                            <div class="card-header">
                                <h5 class="card-title fw-semibold">Data Belum diterima</h5>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-borderless" id="belum_daful">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>Asal Sekolah</th>
                                            <th>Gelombang</th>
                                            <th>Jarak</th>
                                            <th>Nilai</th>
                                            <th>Penghasilan Ayah</th>
                                            <th>Penghasilan Ibu</th>
                                            <th>OPTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = ($belum_daful->currentPage() - 1) * $belum_daful->perPage() + 1;
                                        if (request('sort_by') == 'nilai') {
                                            $sortedDataBelum = $belum_daful->sortByDesc('akhir');
                                        } elseif (request('sort_by') == 'jarak') {
                                            $sortedDataBelum = $belum_daful->sortBy('jarak');
                                        } else {
                                            $sortedDataBelum = $belum_daful;
                                        }
                                        @endphp
                                        @foreach($sortedDataBelum as $dp)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{$dp->nama_siswa}}</td>
                                            <td>{{$dp->asal_sekolah}}</td>
                                            <td>{{$dp->gelombang}}</td>
                                            <td>{{$dp->jarak}}KM</td>
                                            <td>{{$dp->akhir}}</td>
                                            <td>{{$dp->penghasilan_ayah}}</td>
                                            <td>{{$dp->penghasilan_ibu}}</td>
                                            <td>
                                                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Option
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a href="{{route('daful', $dp->id)}}"
                                                        class="btn btn-sm btn-block btn-outline-success">Terima✅</a>
                                                        <li><a class="dropdown-item" target="_blank" href="{{ route('pendaftar.lihat', ['id' => $dp->id]) }}">Lihat</a> 
                                                        <li><a class="dropdown-item" href="{{ route('hapus_siswa', $dp->id) }}">Hapus</a></li>                                                        
                                                </ul>
                                                </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $belum_daful->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title fw-semibold">Data Sudah diterima</h5>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-borderless" id="sudah_daful">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>Asal Sekolah</th>
                                            <th>Gelombang</th>
                                            <th>Jarak</th>
                                            <th>Nilai</th>
                                            <th>Penghasilan Ayah</th>
                                            <th>Penghasilan Ibu</th>
                                            <th>OPTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $no = ($sudah_daful->currentPage() - 1) * $sudah_daful->perPage() + 1;
                                        if (request('sort_by') == 'nilai') {
                                            $sortedDataSudah = $sudah_daful->sortByDesc('akhir');
                                        } elseif (request('sort_by') == 'jarak') {
                                            $sortedDataSudah = $sudah_daful->sortBy('jarak');
                                        } else {
                                            $sortedDataSudah = $sudah_daful;
                                        }
                                    @endphp
                                        @foreach($sortedDataSudah as $dp)
                                            <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{$dp->nama_siswa}}</td>
                                            <td>{{$dp->asal_sekolah}}</td>
                                            <td>{{$dp->gelombang}}</td>
                                            <td>{{$dp->jarak}}KM</td>
                                            <td>{{$dp->akhir}}</td>
                                            <td>{{$dp->penghasilan_ayah}}</td>
                                            <td>{{$dp->penghasilan_ibu}}</td>
                                            <td>
                                                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Option
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <li><a class="dropdown-item" target="_blank" href="{{ route('pendaftar.lihat', ['id' => $dp->id]) }}">Lihat</a> 
                                                    <li><a class="dropdown-item" href="{{ route('hapus_siswa', $dp->id) }}">Hapus</a></li>
                                                </ul>
                                                </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $sudah_daful->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>
</div>
@endsection
