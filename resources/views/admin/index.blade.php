@extends('layouts.dashboard.app')

@section('content')
    <div class="container-fluid">
        {{-- Row 1: Gelombang Statistics --}}
        <div class="row g-4 mb-4">
            @foreach($gelombangList as $index => $gelombang)
                @php
                    $colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                    $color = $colors[$index % count($colors)];
                    $count = $gelombangCounts[$gelombang] ?? 0;
                @endphp
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex gap-3">
                            <div class="bg-{{ $color }} bg-opacity-10 rounded p-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-user fs-4 text-{{ $color }}"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">{{ $gelombang }}</h6>
                                <h3 class="fw-bold mb-0">{{ $count }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!--  Row 2 -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">Statistik Seleksi</h6>
                    </div>
                    <div class="card-body">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row g-3">
                    <div class="col-12">
                        <!-- Total Pendaftar -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-8">
                                        <h6 class="card-title text-muted mb-2">Total Pendaftar</h6>
                                        <h3 class="fw-bold mb-3">{{ $total_pendaftar }}</h3>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="me-2 bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="ti ti-gender-male text-primary fs-6"></i>
                                            </span>
                                            <div>
                                                <span class="fw-semibold">{{ $data_lelaki }}</span>
                                                <small class="text-muted ms-1">laki-laki</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="ti ti-gender-female text-danger fs-6"></i>
                                            </span>
                                            <div>
                                                <span class="fw-semibold">{{ $data_perempuan }}</span>
                                                <small class="text-muted ms-1">perempuan</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="ti ti-users text-primary fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Sudah ACC -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-8">
                                        <h6 class="card-title text-muted mb-2">Sudah ACC</h6>
                                        <h3 class="fw-bold mb-3">{{ $sudah_acc }}</h3>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="ti ti-ban text-warning fs-6"></i>
                                            </span>
                                            <div>
                                                <span class="fw-semibold">{{ $belum_acc }}</span>
                                                <small class="text-muted ms-1">belum acc</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="ti ti-circle-check text-success fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Diterima -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-8">
                                        <h6 class="card-title text-muted mb-2">Diterima</h6>
                                        <h3 class="fw-bold mb-3">{{ $diterima }}</h3>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="me-2 bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="ti ti-x text-danger fs-6"></i>
                                            </span>
                                            <div>
                                                <span class="fw-semibold">{{ $ditolak }}</span>
                                                <small class="text-muted ms-1">ditolak</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="ti ti-clock text-info fs-6"></i>
                                            </span>
                                            <div>
                                                <span class="fw-semibold">{{ $pending }}</span>
                                                <small class="text-muted ms-1">pending</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="ti ti-check text-info fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Row 3 --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">Pendaftar Terbaru</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="data_pendaftar">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold text-muted">No</th>
                                        <th class="fw-semibold text-muted">Nama Lengkap</th>
                                        <th class="fw-semibold text-muted">Asal Sekolah</th>
                                        <th class="fw-semibold text-muted">Jenis Kelamin</th>
                                        <th class="fw-semibold text-muted">Tanggal Daftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_pendaftar as $dp)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="fw-semibold">{{ $dp->nama_siswa }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $dp->asal_sekolah }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $dp->jenis_kelamin }}</span>
                                        </td>
                                        <td>{{ $dp->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

