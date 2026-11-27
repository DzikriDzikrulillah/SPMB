@extends('layouts.dashboard.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header & Action Section -->
    <div class="row g-3 mb-4">
        <!-- Filter Card -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-3 p-md-4">
                    <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-funnel text-primary"></i> Filter Data Pendaftar
                    </h6>
                    <form method="GET" class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted style-xs">Jalur Pendaftaran</label>
                            <select name="jalur" class="form-select form-select-sm">
                                <option value="">Semua Jalur</option>
                                @foreach($jalurList as $jalur)
                                    <option value="{{ $jalur }}" {{ $selectedJalur === $jalur ? 'selected' : '' }}>{{ $jalur }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted style-xs">Gelombang</label>
                            <select name="gelombang" class="form-select form-select-sm">
                                <option value="">Semua Gelombang</option>
                                @foreach($gelombangList as $gelombang)
                                    <option value="{{ $gelombang }}" {{ $selectedGelombang === $gelombang ? 'selected' : '' }}>{{ $gelombang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted style-xs">Jurusan</label>
                            <select name="jurusan" class="form-select form-select-sm">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusanList as $jurusan)
                                    <option value="{{ $jurusan }}" {{ $selectedJurusan === $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-semibold text-muted style-xs">Urutkan Berdasarkan</label>
                            <select name="sort_by" class="form-select form-select-sm">
                                <option value="">Default</option>
                                <option value="nilai" {{ $sortBy === 'nilai' ? 'selected' : '' }}>Nilai Tertinggi</option>
                                <option value="jarak_km" {{ $sortBy === 'jarak_km' ? 'selected' : '' }}>Jarak Terdekat</option>
                                <option value="nama" {{ $sortBy === 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="terbaru" {{ $sortBy === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted style-xs">Tampilkan</label>
                            <select name="per_page" class="form-select form-select-sm">
                                @foreach([5,10,25,50,100] as $size)
                                    <option value="{{ $size }}" {{ (int) $perPage === $size ? 'selected' : '' }}>{{ $size }} baris</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                <i class="bi bi-filter me-1"></i> Terapkan
                            </button>
                            <a href="{{ route('pendaftar.belum_acc') }}" class="btn btn-light btn-sm text-muted">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Action Card: ACC Massal -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3 h-100 bg-success-subtle border-success-subtle">
                <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            <h6 class="fw-bold mb-0 text-success">ACC Massal Pendaftar</h6>
                        </div>
                        <p class="text-muted style-xs mb-3">Verifikasi dan terima seluruh pendaftar pada gelombang tertentu sekaligus.</p>
                    </div>

                    <form action="{{ route('acc_massal') }}" method="POST" class="js-confirm-form m-0" data-confirm-title="ACC massal murid?" data-confirm-text="Semua murid pada gelombang terpilih akan di-ACC.">
                        @csrf
                        <div class="input-group input-group-sm">
                            <select name="gelombang" class="form-select border-success-subtle" required>
                                <option value="all">Semua Gelombang</option>
                                <option value="Gelombang_1">Gelombang 1</option>
                                <option value="Gelombang_2">Gelombang 2</option>
                                <option value="Gelombang_3">Gelombang 3</option>
                                <option value="Gelombang_4">Gelombang 4</option>
                            </select>
                            <button type="submit" class="btn btn-success fw-semibold px-3">
                                <i class="bi bi-check-lg me-1"></i> ACC Massal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold mb-0 text-dark">Pendaftar Belum ACC</h6>
                <small class="text-muted">Data calon siswa yang sedang menunggu verifikasi berkas</small>
            </div>
            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2 fw-semibold">
                Total: {{ $data_pendaftar->total() }} murid
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="ps-3 py-3 text-center" style="width: 60px;">No</th>
                            <th style="min-width: 200px;">Nama / NIK</th>
                            <th>Asal Sekolah</th>
                            <th>Jalur</th>
                            <th>Gelombang</th>
                            <th>Jarak</th>
                            <th>Nilai Akhir</th>
                            <th class="pe-3 text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data_pendaftar as $i => $dp)
                            <tr>
                                <td class="ps-3 text-center fw-semibold text-muted">
                                    {{ $i + $data_pendaftar->firstItem() }}
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $dp->nama_siswa }}</div>
                                    <small class="text-muted style-xs"><i class="bi bi-card-heading me-1"></i>{{ $dp->nik }}</small>
                                </td>
                                <td class="text-secondary">{{ $dp->asal_sekolah }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $dp->jalur }}</span></td>
                                <td><span class="badge bg-light text-dark border">{{ $dp->gelombang }}</span></td>
                                <td>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $dp->jarak_km }} KM
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold">
                                        {{ $dp->akhir }}
                                    </span>
                                </td>
                                <td class="pe-3 text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('acc', $dp->id) }}" class="btn btn-outline-success js-confirm-link" data-confirm-title="ACC murid ini?" data-confirm-text="murid akan dipindahkan ke data terverifikasi." title="ACC murid">
                                            <i class="bi bi-check-lg"></i>
                                        </a>
                                        <a target="_blank" href="{{ route('pendaftar.lihat', $dp->id) }}" class="btn btn-outline-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('hapus_siswa', $dp->id) }}" class="btn btn-outline-danger js-confirm-link" data-confirm-title="Hapus data murid?" data-confirm-text="Data murid akan dihapus permanen." title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                    Tidak ada data pendaftar yang belum di-ACC.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-top p-3 d-flex align-items-center justify-content-between">
            <small class="text-muted">
                Menampilkan {{ $data_pendaftar->firstItem() ?? 0 }} - {{ $data_pendaftar->lastItem() ?? 0 }} dari {{ $data_pendaftar->total() }} pendaftar
            </small>
            <div>
                {{ $data_pendaftar->links() }}
            </div>
        </div>
    </div>
</div>
@endsection