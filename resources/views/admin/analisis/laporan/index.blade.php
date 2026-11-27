@extends('layouts.dashboard.app')

@section('content')
<!-- HEADER SECTION -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold mb-1 text-dark">Laporan Seleksi</h4>
        <p class="text-muted small mb-0">Ringkasan status berkas, hasil seleksi akhir, serta ekspor data murid.</p>
    </div>
    <a href="{{ route('admin.analisis.laporan.excel') }}" class="btn btn-success btn-sm px-3 shadow-sm flex-shrink-0">
        <i class="bi bi-file-earmark-excel-fill me-1"></i> Export Excel (Multi-Sheet)
    </a>
</div>

<!-- STATS OVERVIEW CARDS -->
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

<!-- MAIN DATA CARD WITH TAB NAVIGATION -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom pt-3 pb-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <!-- TAB BUTTONS -->
            <ul class="nav nav-tabs card-header-tabs border-bottom-0" id="laporanTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold py-2" id="acc-tab" data-bs-toggle="tab" data-bs-target="#acc-pane" type="button" role="tab">
                        <i class="ti ti-file-check text-primary me-1"></i> ACC Berkas
                        <span class="badge bg-primary-subtle text-primary ms-1">{{ $summary['acc'] }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold py-2" id="tidak-acc-tab" data-bs-toggle="tab" data-bs-target="#tidak-acc-pane" type="button" role="tab">
                        <i class="ti ti-file-x text-secondary me-1"></i> Tidak ACC
                        <span class="badge bg-secondary-subtle text-secondary ms-1">{{ $summary['tidak_acc'] }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold py-2" id="diterima-tab" data-bs-toggle="tab" data-bs-target="#diterima-pane" type="button" role="tab">
                        <i class="ti ti-check text-success me-1"></i> Diterima
                        <span class="badge bg-success-subtle text-success ms-1">{{ $summary['diterima'] }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold py-2" id="ditolak-tab" data-bs-toggle="tab" data-bs-target="#ditolak-pane" type="button" role="tab">
                        <i class="ti ti-x text-danger me-1"></i> Ditolak
                        <span class="badge bg-danger-subtle text-danger ms-1">{{ $summary['ditolak'] }}</span>
                    </button>
                </li>
            </ul>

            <!-- COMPACT PER PAGE CONTROL -->
            <form method="GET" class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                <label class="form-label small text-muted mb-0 text-nowrap">Tampilkan:</label>
                <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                    @foreach([5,10,25,50,100] as $size)
                        <option value="{{ $size }}" {{ (int) $perPage === $size ? 'selected' : '' }}>{{ $size }} data</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="tab-content" id="laporanTabContent">
            
            <!-- TAB 1: ACC BERKAS -->
            <div class="tab-pane fade show active" id="acc-pane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-3 py-3">Nama Siswa</th>
                                <th>Jalur Pendaftaran</th>
                                <th class="text-end pe-3">Status Seleksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($acc as $item)
                                <tr>
                                    <td class="ps-3 fw-medium text-dark">{{ $item->nama_siswa }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->jalur }}</span></td>
                                    <td class="text-end pe-3">
                                        @if(strtolower($item->status_seleksi) === 'diterima')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Diterima</span>
                                        @elseif(strtolower($item->status_seleksi) === 'ditolak')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada data murid ACC.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top">
                    {{ $acc->links() }}
                </div>
            </div>

            <!-- TAB 2: TIDAK ACC -->
            <div class="tab-pane fade" id="tidak-acc-pane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-3 py-3">Nama Siswa</th>
                                <th>Jalur Pendaftaran</th>
                                <th class="text-end pe-3">Status ACC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tidakAcc as $item)
                                <tr>
                                    <td class="ps-3 fw-medium text-dark">{{ $item->nama_siswa }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->jalur }}</span></td>
                                    <td class="text-end pe-3">
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Belum ACC</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Semua berkas murid sudah di-ACC.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top">
                    {{ $tidakAcc->links() }}
                </div>
            </div>

            <!-- TAB 3: DITERIMA -->
            <div class="tab-pane fade" id="diterima-pane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-3 py-3">Nama Siswa</th>
                                <th>Jalur Pendaftaran</th>
                                <th class="text-end pe-3">Ranking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($diterima as $item)
                                <tr>
                                    <td class="ps-3 fw-medium text-dark">{{ $item->nama_siswa }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->jalur }}</span></td>
                                    <td class="text-end pe-3">
                                        <span class="fw-bold text-success">#{{ optional($item->hasilWaspas)->ranking_jalur ?? '-' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada murid yang diterima.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top">
                    {{ $diterima->links() }}
                </div>
            </div>

            <!-- TAB 4: DITOLAK -->
            <div class="tab-pane fade" id="ditolak-pane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-3 py-3">Nama Siswa</th>
                                <th>Jalur Pendaftaran</th>
                                <th class="text-end pe-3">Ranking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ditolak as $item)
                                <tr>
                                    <td class="ps-3 fw-medium text-dark">{{ $item->nama_siswa }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->jalur }}</span></td>
                                    <td class="text-end pe-3">
                                        <span class="text-muted">#{{ optional($item->hasilWaspas)->ranking_jalur ?? '-' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada murid yang ditolak.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top">
                    {{ $ditolak->links() }}
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Custom tab styling for more distinct active state */
    #laporanTab .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
    }
    
    #laporanTab .nav-link:hover {
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    #laporanTab .nav-link.active {
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.1);
        border-bottom: 3px solid #0d6efd;
        font-weight: 600;
    }
</style>
@endsection