@extends('layouts.dashboard.app')

@section('content')
<!-- SECTION FILTER -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted text-sm">Filter Jalur</label>
                <select name="jalur" class="form-select form-select-sm">
                    <option value="">Semua Jalur</option>
                    @foreach($jalurList as $jalur)
                        <option value="{{ $jalur }}" {{ $selectedJalur === $jalur ? 'selected' : '' }}>{{ $jalur }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted text-sm">Filter Gelombang</label>
                <select name="gelombang" class="form-select form-select-sm">
                    <option value="">Semua Gelombang</option>
                    @foreach($gelombangList as $gelombang)
                        <option value="{{ $gelombang }}" {{ $selectedGelombang === $gelombang ? 'selected' : '' }}>{{ $gelombang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted text-sm">Filter Jurusan</label>
                <select name="jurusan" class="form-select form-select-sm">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusanList as $jurusan)
                        <option value="{{ $jurusan }}" {{ $selectedJurusan === $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted text-sm">Urutkan</label>
                <select name="sort_by" class="form-select form-select-sm">
                    <option value="">Default</option>
                    <option value="nilai" {{ $sortBy === 'nilai' ? 'selected' : '' }}>Nilai Tertinggi</option>
                    <option value="jarak_km" {{ $sortBy === 'jarak_km' ? 'selected' : '' }}>Jarak Terdekat</option>
                    <option value="nama" {{ $sortBy === 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="terbaru" {{ $sortBy === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold text-muted text-sm">Jumlah Data</label>
                <select name="per_page" class="form-select form-select-sm">
                    @foreach([5,10,25,50,100] as $size)
                        <option value="{{ $size }}" {{ (int) $perPage === $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-funnel"></i> Terapkan
                </button>
                <a href="{{ route('pendaftar.terverifikasi') }}" class="btn btn-outline-secondary btn-sm w-100">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- SECTION TABEL PENDAFTAR -->
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white border-0 py-3">
        <div>
            <h6 class="fw-bold mb-1">Pendaftar Terverifikasi</h6>
            <small class="text-muted">Data pendaftar yang sudah diverifikasi</small>
        </div>
        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
            Total: {{ $data_acc->total() }}
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th class="fw-semibold text-muted">No</th>
                        <th class="fw-semibold text-muted">Nama</th>
                        <th class="fw-semibold text-muted">Sekolah</th>
                        <th class="fw-semibold text-muted">Jalur</th>
                        <th class="fw-semibold text-muted">Gelombang</th>
                        <th class="fw-semibold text-muted">Jarak</th>
                        <th class="fw-semibold text-muted">Nilai</th>
                        <th class="fw-semibold text-muted text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data_acc as $i => $dp)
                        <tr>
                            <td>{{ $i + $data_acc->firstItem() }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $dp->nama_siswa }}</div>
                                        <small class="text-muted">{{ $dp->nik }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $dp->asal_sekolah }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $dp->jalur }}</span></td>
                            <td><span class="badge bg-light text-dark border">{{ $dp->gelombang }}</span></td>
                            <td><span class="badge bg-info bg-opacity-10 text-info">{{ $dp->jarak_km }} KM</span></td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $dp->akhir }}</span></td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a target="_blank" href="{{ route('pendaftar.lihat', $dp->id) }}" class="btn btn-outline-info btn-sm" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('hapus_siswa', $dp->id) }}" class="btn btn-outline-danger btn-sm js-confirm-link" data-confirm-title="Hapus data murid?" data-confirm-text="Data murid akan dihapus permanen." title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Tidak ada data pendaftar terverifikasi yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        <div class="d-flex justify-content-end">
            {{ $data_acc->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection