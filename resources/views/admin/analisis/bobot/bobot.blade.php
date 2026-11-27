@extends('layouts.dashboard.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">Pengaturan Bobot Kriteria</h4>
            <p class="text-muted small mb-0">Atur pembobotan metode WASPAS untuk setiap jalur pendaftaran.</p>
        </div>
        <div class="alert alert-info py-2 px-3 mb-0 d-flex align-items-center gap-2 border-0 shadow-sm">
            <i class="ti ti-info-circle fs-5"></i>
            <span class="small">Aturan: Total bobot untuk setiap jalur wajib bernilai tepat <strong>1.00</strong>.</span>
        </div>
    </div>

    <form action="{{ route('admin.analisis.bobot.update') }}" method="POST" id="formBobot">
        @csrf

        <div class="row g-4">
            @foreach($jalurList as $jalur)
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100 rounded-3">
                        <!-- Card Header Jalur -->
                        <div class="card-header bg-white py-3 border-bottom border-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-2 p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="ti ti-adjustments-horizontal fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $jalur->jalur }}</h6>
                                    <small class="text-muted">{{ $jalur->deskripsi_jalur ?? 'Jalur Pendaftaran' }}</small>
                                </div>
                            </div>
                            <span class="total-badge-{{ $loop->index }} fw-bold text-danger">0.00 / 1.00</span>
                        </div>

                        <!-- Card Body Input -->
                        <div class="card-body p-4">
                            <input type="hidden" name="bobot[{{ $loop->index }}][jalur_id]" value="{{ $jalur->id }}">

                            <div class="row g-3 jalur-group" data-index="{{ $loop->index }}">
                                <!-- Bobot Jarak -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label fw-semibold text-dark mb-0 small">Jarak Rumah</label>
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle small">Cost</span>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <input
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                max="1"
                                                name="bobot[{{ $loop->index }}][bobot_jarak]"
                                                class="form-control bobot-input"
                                                value="{{ old('bobot.' . $loop->index . '.bobot_jarak', $jalur->bobotKriteria->bobot_jarak ?? 0) }}"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>

                                <!-- Bobot Penghasilan -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label fw-semibold text-dark mb-0 small">Penghasilan Ortu</label>
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle small">Cost</span>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <input
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                max="1"
                                                name="bobot[{{ $loop->index }}][bobot_penghasilan_orangtua]"
                                                class="form-control bobot-input"
                                                value="{{ old('bobot.' . $loop->index . '.bobot_penghasilan_orangtua', $jalur->bobotKriteria->bobot_penghasilan_orangtua ?? 0) }}"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>

                                <!-- Bobot Nilai Akhir -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label fw-semibold text-dark mb-0 small">Nilai Rapor/Akhir</label>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle small">Benefit</span>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <input
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                max="1"
                                                name="bobot[{{ $loop->index }}][bobot_nilai_akhir]"
                                                class="form-control bobot-input"
                                                value="{{ old('bobot.' . $loop->index . '.bobot_nilai_akhir', $jalur->bobotKriteria->bobot_nilai_akhir ?? 0) }}"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>

                                <!-- Bobot Nilai US -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label fw-semibold text-dark mb-0 small">Nilai Ujian Sekolah</label>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle small">Benefit</span>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <input
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                max="1"
                                                name="bobot[{{ $loop->index }}][bobot_us]"
                                                class="form-control bobot-input"
                                                value="{{ old('bobot.' . $loop->index . '.bobot_us', $jalur->bobotKriteria->bobot_us ?? 0) }}"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Sticky Floating Action Bar -->
        <div class="card border-0 shadow-lg mt-4 position-sticky bottom-0 z-3">
            <div class="card-body d-flex align-items-center justify-content-between py-3">
                <button type="submit" class="btn btn-primary px-4 d-flex align-items-center gap-2">
                    <i class="ti ti-device-floppy fs-5"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript untuk Kalkulasi Otomatis Total Bobot -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function calculateTotals() {
        const groups = document.querySelectorAll('.jalur-group');
        let allValid = true;

        groups.forEach(group => {
            const index = group.getAttribute('data-index');
            const inputs = group.querySelectorAll('.bobot-input');
            let total = 0;

            inputs.forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            total = Math.round(total * 100) / 100; // Pembulatan 2 desimal
            const isValid = Math.abs(total - 1.00) < 0.001;
            allValid = allValid && isValid;

            const badge = document.querySelector(`.total-badge-${index}`);
            if (badge) {
                badge.textContent = `${total.toFixed(2)} / 1.00`;
                if (isValid) {
                    badge.className = `total-badge-${index} fw-bold text-success`;
                } else {
                    badge.className = `total-badge-${index} fw-bold text-danger`;
                }
            }
        });

        return allValid;
    }

    // Hitung saat halaman selesai dimuat
    calculateTotals();

    // Hitung ulang tiap kali ada perubahan input
    document.querySelectorAll('.bobot-input').forEach(input => {
        input.addEventListener('input', calculateTotals);
    });

    document.getElementById('formBobot').addEventListener('submit', function (event) {
        if (!calculateTotals()) {
            event.preventDefault();
            window.alert('Total bobot setiap jalur harus tepat 1.00.');
        }
    });
});
</script>
@endpush
@endsection