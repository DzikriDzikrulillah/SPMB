@extends('layouts.dashboard.app')

@section('content')
<!-- 1. STATS OVERVIEW CARDS (Compact & Visual) -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium d-block mb-1">ACC Berkas</span>
                    <h3 class="fw-bold text-dark mb-0">{{ $summary['acc'] }}</h3>
                </div>
                <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3">
                    <i class="ti ti-file-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium d-block mb-1">Tidak ACC</span>
                    <h3 class="fw-bold text-dark mb-0">{{ $summary['tidak_acc'] }}</h3>
                </div>
                <div class="p-3 bg-secondary bg-opacity-10 text-secondary rounded-3">
                    <i class="ti ti-file-x fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium d-block mb-1">Diterima</span>
                    <h3 class="fw-bold text-success mb-0">{{ $summary['diterima'] }}</h3>
                </div>
                <div class="p-3 bg-success bg-opacity-10 text-success rounded-3">
                    <i class="ti ti-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium d-block mb-1">Ditolak</span>
                    <h3 class="fw-bold text-danger mb-0">{{ $summary['ditolak'] }}</h3>
                </div>
                <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-3">
                    <i class="ti ti-x fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. RINGKASAN KUOTA & PENDAFTAR PER JALUR (Diintegrasikan) -->
@if(!empty($summary['jalur_summary']))
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-transparent border-bottom py-3 d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0 text-dark">
                <i class="bi bi-bar-chart-fill text-primary me-2"></i>Ringkasan Kuota & Pendaftar per Jalur
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 py-3 fw-semibold">Jalur</th>
                            <th class="text-center fw-semibold">Kuota</th>
                            <th class="text-center fw-semibold">Total Pendaftar</th>
                            <th class="text-center fw-semibold">Total ACC</th>
                            <th class="text-center fw-semibold">Diterima</th>
                            <th class="text-center fw-semibold">Ditolak</th>
                            <th class="text-center fw-semibold">Pending</th>
                            <th class="text-end pe-3 fw-semibold">Sisa Kuota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($summary['jalur_summary'] as $row)
                            <tr>
                                <td class="ps-3 fw-medium text-dark">{{ $row['jalur'] }}</td>
                                <td class="text-center"><span class="badge bg-light text-dark border">{{ $row['kuota'] }}</span></td>
                                <td class="text-center fw-semibold text-primary">{{ $row['total_pendaftar'] }}</td>
                                <td class="text-center">{{ $row['total_acc'] }}</td>
                                <td class="text-center text-success fw-medium">{{ $row['diterima'] }}</td>
                                <td class="text-center text-danger fw-medium">{{ $row['ditolak'] }}</td>
                                <td class="text-center text-warning fw-medium">{{ $row['pending'] }}</td>
                                <td class="text-end pe-3">
                                    <span class="fw-bold {{ $row['sisa_kuota'] <= 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $row['sisa_kuota'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<!-- 3. ACTION & FILTER PANEL (Dibuat Kompak) -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <!-- Action Banner: Seleksi Otomatis -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center p-3 bg-light rounded-3 mb-4 gap-3 border">
            <div>
                <h6 class="fw-bold text-dark mb-1"><i class="bi bi-magic text-success me-1"></i> Seleksi Otomatis</h6>
                <p class="text-muted small mb-0">Terapkan kuota otomatis untuk menentukan kelulusan tiap jalur secara instan.</p>
            </div>
            <form action="{{ route('admin.analisis.seleksi.otomatis') }}" method="POST" class="js-confirm-form flex-shrink-0" data-confirm-title="Terapkan seleksi otomatis per jalur?" data-confirm-text="Sistem akan menggunakan kuota yang tersimpan untuk tiap jalur.">
                @csrf
                <button class="btn btn-success btn-sm px-3 fw-medium" type="submit">
                    <i class="bi bi-lightning-fill me-1"></i> Terapkan Kuota Per Jalur
                </button>
            </form>
        </div>

        <hr class="text-muted opacity-25 my-4">

        <!-- Form Filter Data -->
        <form method="GET" class="row g-3">
            <div class="col-md-3 col-sm-6">
                <label class="form-label small fw-semibold text-secondary">Jalur</label>
                <select name="jalur" class="form-select form-select-sm">
                    <option value="">Semua Jalur</option>
                    @foreach($jalurOptions as $jalur)
                        <option value="{{ $jalur }}" {{ $selectedJalur === $jalur ? 'selected' : '' }}>{{ $jalur }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <label class="form-label small fw-semibold text-secondary">Gelombang</label>
                <select name="gelombang" class="form-select form-select-sm">
                    <option value="">Semua Gelombang</option>
                    @foreach($gelombangOptions as $gelombang)
                        <option value="{{ $gelombang }}" {{ $selectedGelombang === $gelombang ? 'selected' : '' }}>{{ $gelombang }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <label class="form-label small fw-semibold text-secondary">Jurusan</label>
                <select name="jurusan" class="form-select form-select-sm">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusanOptions as $jurusan)
                        <option value="{{ $jurusan }}" {{ $selectedJurusan === $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <label class="form-label small fw-semibold text-secondary">Urutkan Berdasarkan</label>
                <select name="sort_by" class="form-select form-select-sm">
                    <option value="">Default</option>
                    <option value="qi" {{ $sortBy === 'qi' ? 'selected' : '' }}>Qi Tertinggi</option>
                    <option value="nama" {{ $sortBy === 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="jarak" {{ $sortBy === 'jarak' ? 'selected' : '' }}>Jarak Terdekat</option>
                    <option value="nilai" {{ $sortBy === 'nilai' ? 'selected' : '' }}>Nilai Tertinggi</option>
                </select>
            </div>

            <div class="col-md-2 col-sm-4">
                <label class="form-label small fw-semibold text-secondary">Tampilkan</label>
                <select name="per_page" class="form-select form-select-sm">
                    @foreach([5,10,25,50,100] as $size)
                        <option value="{{ $size }}" {{ (int) $perPage === $size ? 'selected' : '' }}>{{ $size }} Data</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-10 col-sm-8 d-flex align-items-end justify-content-end gap-2">
                <a href="{{ route('admin.analisis.seleksi.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
                <button class="btn btn-primary btn-sm px-4">
                    <i class="bi bi-funnel"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <h6 class="fw-bold mb-0">Hasil Seleksi WASPAS</h6>
        <div class="d-flex flex-wrap align-items-center gap-2 small">
            <span class="badge bg-success-subtle bg-opacity-25 text-success border border-success-subtle rounded-pill px-2 py-1">
                <i class="bi bi-check-circle me-1"></i>Hijau = direkomendasikan untuk diterima
            </span>
            <span class="badge bg-danger-subtle bg-opacity-25 text-danger border border-danger-subtle rounded-pill px-2 py-1">
                <i class="bi bi-x-circle me-1"></i>Merah = tidak direkomendasikan
            </span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-semibold text-muted">Ranking</th>
                        <th class="fw-semibold text-muted">murid</th>
                        <th class="fw-semibold text-muted">Jalur</th>
                        <th class="fw-semibold text-muted">Qi</th>
                        <th class="fw-semibold text-muted">Status Seleksi</th>
                        <th class="fw-semibold text-muted text-center">Aksi Manual</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $kuotaMap = collect($summary['jalur_summary'] ?? [])->mapWithKeys(function ($row) {
                            $jalurKey = strtolower(trim((string) preg_replace('/^jalur\s+/i', '', $row['jalur'] ?? '')));
                            return [$jalurKey => (int) ($row['kuota'] ?? 0)];
                        })->all();
                    @endphp
                    @forelse($hasil as $item)
                    @php
                        $jalurKey = strtolower(trim((string) preg_replace('/^jalur\s+/i', '', $item->jalur ?? '')));
                        $kuota = (int) ($kuotaMap[$jalurKey] ?? 0);
                        $isRecommended = $kuota > 0 && (int) $item->ranking_jalur <= $kuota;
                        
                        // Menentukan warna background cell (Bootstrap background utilities)
                        $bgClass = $isRecommended ? 'bg-success bg-opacity-25' : 'bg-danger bg-opacity-25';
                    @endphp
                    <tr>
                        <td class="{{ $bgClass }}">
                            <span class="badge bg-primary bg-opacity-10 text-primary">#{{ $item->ranking_jalur }}</span>
                        </td>
                        <td class="{{ $bgClass }}">
                            <div class="d-flex align-items-center">
                                <div>
                                    <div class="fw-semibold">{{ $item->pendaftar->nama_siswa }}</div>
                                    <small class="text-muted">{{ $item->pendaftar->nisn }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="{{ $bgClass }}"><span class="badge bg-light text-dark border">{{ $item->jalur }}</span></td>
                        <td class="{{ $bgClass }}"><span class="badge bg-info bg-opacity-10 text-info">{{ number_format($item->qi, 4) }}</span></td>
                        <td class="{{ $bgClass }}">
                            @php $status = $item->pendaftar->status_seleksi; @endphp
                            @if($status === 'diterima')
                                <span class="badge bg-success text-white">Diterima</span>
                            @elseif($status === 'ditolak')
                                <span class="badge bg-danger text-white">Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td class="{{ $bgClass }} text-center">
                            <div class="btn-group">
                                <a target="_blank" href="{{ route('pendaftar.lihat', $item->pendaftar_id) }}" class="btn btn-outline-info btn-sm bg-white" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('admin.analisis.seleksi.manual', $item->pendaftar_id) }}" method="POST" class="js-confirm-form" data-confirm-title="Terima murid ini?" data-confirm-text="Status seleksi murid akan diubah menjadi diterima.">
                                    @csrf
                                    <input type="hidden" name="status_seleksi" value="diterima">
                                    <button class="btn btn-outline-success btn-sm bg-white" title="Terima">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.analisis.seleksi.manual', $item->pendaftar_id) }}" method="POST" class="js-confirm-form" data-confirm-title="Tolak murid ini?" data-confirm-text="Status seleksi murid akan diubah menjadi ditolak.">
                                    @csrf
                                    <input type="hidden" name="status_seleksi" value="ditolak">
                                    <button class="btn btn-outline-danger btn-sm bg-white" title="Tolak">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    <p>Belum ada ranking WASPAS untuk diproses.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-0">
            {{ $hasil->links() }}
        </div>
    </div>
</div>
@endsection
