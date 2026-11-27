@extends('layouts.dashboard.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header & Action Card -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h4 class="fw-bold mb-0">Hasil Analisis WASPAS</h4>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                            <i class="ti ti-check fs-7"></i> ACC Berkas Only
                        </span>
                    </div>
                    <p class="text-muted small mb-0">Perhitungan perangkingan murid berdasarkan pembobotan kriteria WASPAS.</p>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="bg-light border rounded-3 px-3 py-2 text-center">
                        <span class="text-muted small d-block">Total murid Terhitung</span>
                        <span class="fs-5 fw-bold text-primary">{{ $info['approved_count'] }}</span>
                    </div>

                    <form action="{{ route('admin.analisis.waspas.export') }}" method="GET" class="m-0">
                        <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2 px-3 py-2">
                            <i class="ti ti-download fs-5"></i>
                            <span>Export Excel</span>
                        </button>
                    </form>

                    <form action="{{ route('admin.analisis.waspas.proses') }}" method="POST" class="js-confirm-form m-0" data-confirm-title="Proses ulang WASPAS?" data-confirm-text="Perhitungan lama akan diperbarui dengan data terbaru.">
                        @csrf
                        <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2">
                            <i class="ti ti-refresh fs-5"></i>
                            <span>Proses Ulang WASPAS</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Warning jika ada Bobot Kosong -->
    @if(!empty($info['missing_weights']))
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center gap-2 mb-4">
            <i class="ti ti-alert-triangle fs-4 text-warning"></i>
            <div>
                Data ACC ditemukan, tetapi jalur berikut belum memiliki konfigurasi bobot: 
                <strong>{{ implode(', ', $info['missing_weights']) }}</strong>.
            </div>
        </div>
    @endif

    <!-- Card Filter -->
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body p-3 p-md-4">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Jalur Pendaftaran</label>
                    <select name="jalur" class="form-select form-select-sm">
                        <option value="">Semua Jalur</option>
                        @foreach($jalurOptions as $jalur)
                            <option value="{{ $jalur }}" {{ $selectedJalur === $jalur ? 'selected' : '' }}>{{ $jalur }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Gelombang</label>
                    <select name="gelombang" class="form-select form-select-sm">
                        <option value="">Semua Gelombang</option>
                        @foreach($gelombangOptions as $gelombang)
                            <option value="{{ $gelombang }}" {{ $selectedGelombang === $gelombang ? 'selected' : '' }}>{{ $gelombang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Jurusan</label>
                    <select name="jurusan" class="form-select form-select-sm">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusanOptions as $jurusan)
                            <option value="{{ $jurusan }}" {{ $selectedJurusan === $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Urutkan Berdasarkan</label>
                    <select name="sort_by" class="form-select form-select-sm">
                        <option value="">Default</option>
                        <option value="qi" {{ $sortBy === 'qi' ? 'selected' : '' }}>Nilai Qi (Siswa Terbaik)</option>
                        <option value="nama" {{ $sortBy === 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="jarak" {{ $sortBy === 'jarak' ? 'selected' : '' }}>Jarak Terdekat</option>
                        <option value="nilai" {{ $sortBy === 'nilai' ? 'selected' : '' }}>Nilai Rata-rata Tertinggi</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Tampilkan</label>
                    <select name="per_page" class="form-select form-select-sm">
                        @foreach([10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ (int) $perPage === $size ? 'selected' : '' }}>{{ $size }} data</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-10 d-flex align-items-end justify-content-end gap-2">
                    <a href="{{ route('admin.analisis.waspas.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                        <i class="ti ti-rotate-clockwise"></i> Reset
                    </a>
                    <button class="btn btn-primary btn-sm px-4">
                        <i class="ti ti-filter"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Nilai Extremes Min/Max Card -->
    @if(!empty($selectedJalur) && !empty($extremes))
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body p-3 p-md-4">
                <h6 class="fw-bold mb-3 text-dark">
                    <i class="ti ti-chart-bar me-1 text-primary"></i> Acuan Nilai Maksimal / Minimal Jalur: <span class="text-primary">{{ $selectedJalur }}</span>
                </h6>
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <div class="bg-light rounded-3 p-3 border">
                            <span class="text-muted style-xs d-block">Max Nilai Rata-rata</span>
                            <span class="fs-5 fw-bold text-dark">{{ number_format($extremes['max_nilai_akhir'], 2) }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="bg-light rounded-3 p-3 border">
                            <span class="text-muted style-xs d-block">Max Ujian Sekolah</span>
                            <span class="fs-5 fw-bold text-dark">{{ number_format($extremes['max_us'], 2) }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="bg-light rounded-3 p-3 border">
                            <span class="text-muted style-xs d-block">Min Jarak Rumah</span>
                            <span class="fs-5 fw-bold text-dark">{{ number_format($extremes['min_jarak'], 2) }} km</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="bg-light rounded-3 p-3 border">
                            <span class="text-muted style-xs d-block">Min Penghasilan Ortu</span>
                            <span class="fs-5 fw-bold text-dark">Rp {{ number_format($extremes['min_penghasilan_orangtua'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Data Table Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="ps-3 py-3 text-center" style="width: 70px;">Rank</th>
                            <th style="min-width: 200px;">murid</th>
                            <th>Jalur</th>
                            <!-- Group Data Mentah -->
                            <th class="bg-primary bg-opacity-10 text-primary">Nilai Rata</th>
                            <th class="bg-primary bg-opacity-10 text-primary">Nilai US</th>
                            <th class="bg-primary bg-opacity-10 text-primary">Jarak</th>
                            <th class="bg-primary bg-opacity-10 text-primary">Penghasilan</th>
                            <!-- Group Normalisasi -->
                            <th class="border-start">N. Nilai</th>
                            <th>N. US</th>
                            <th>N. Jarak</th>
                            <th>N. Penghasilan</th>
                            <!-- Nilai Akhir Qi -->
                            {{-- <th class="pe-3 text-end bg-success bg-opacity-10 text-success">Nilai WSM</th>
                            <th class="pe-3 text-end bg-success bg-opacity-10 text-success">Nilai WPM</th> --}}
                            <th class="pe-3 text-end bg-success bg-opacity-10 text-success">Nilai Qi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasil as $item)
                            <tr>
                                <td class="ps-3 text-center">
                                    @if($item->ranking_jalur == 1)
                                        <span class="badge bg-warning text-dark px-2 py-1"><i class="ti ti-trophy"></i> #1</span>
                                    @elseif($item->ranking_jalur == 2)
                                        <span class="badge bg-secondary px-2 py-1">#2</span>
                                    @elseif($item->ranking_jalur == 3)
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">#3</span>
                                    @else
                                        <span class="badge bg-light text-dark border px-2 py-1">#{{ $item->ranking_jalur }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->pendaftar->nama_siswa }}</div>
                                    <small class="text-muted style-xs">{{ $item->pendaftar->asal_sekolah }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $item->jalur }}</span></td>

                                <!-- Data Mentah -->
                                <td class="bg-light">{{ number_format($item->nilai_akhir, 2) }}</td>
                                <td class="bg-light">{{ number_format($item->us, 2) }}</td>
                                <td class="bg-light">{{ number_format($item->jarak, 2) }} km</td>
                                <td class="bg-light">Rp {{ number_format($item->penghasilan_orangtua, 0, ',', '.') }}</td>

                                <!-- Normalisasi -->
                                <td class="border-start text-muted">{{ number_format($item->normalisasi_nilai_akhir, 4) }}</td>
                                <td class="text-muted">{{ number_format($item->normalisasi_us, 4) }}</td>
                                <td class="text-muted">{{ number_format($item->normalisasi_jarak, 4) }}</td>
                                <td class="text-muted">{{ number_format($item->normalisasi_penghasilan_orangtua, 4) }}</td>
                                {{-- <td class="pe-3 text-end bg-success bg-opacity-10 fw-bold text-success">{{ number_format($item->wsm, 4) }}</td>
                                <td class="pe-3 text-end bg-success bg-opacity-10 fw-bold text-success">{{ number_format($item->wpm, 4) }}</td> --}}
                                <!-- Nilai Qi -->
                                <td class="pe-3 text-end bg-success bg-opacity-10 fw-bold text-success">
                                    {{ number_format($item->qi, 4) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted py-5">
                                    <i class="ti ti-folder-off fs-1 d-block mb-2 text-secondary"></i>
                                    Belum ada hasil WASPAS. Pastikan bobot sudah diisi dan murid sudah berstatus ACC.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-3 border-top d-flex align-items-center justify-content-between">
                <small class="text-muted">Menampilkan {{ $hasil->firstItem() ?? 0 }} - {{ $hasil->lastItem() ?? 0 }} dari {{ $hasil->total() }} data</small>
                <div>
                    {{ $hasil->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection