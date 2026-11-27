@extends('layouts.dashboard.app')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white border-0">
        <div>
            <h6 class="fw-bold mb-1">Data Gelombang</h6>
            <small class="text-muted">Kelola gelombang pendaftaran</small>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="data_sekolah">
                <thead class="table-light">
                    <tr>
                        <th class="fw-semibold text-muted">No</th>
                        <th class="fw-semibold text-muted">Gelombang</th>
                        <th class="fw-semibold text-muted">Status</th>
                        <th class="fw-semibold text-muted text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $info)
                        <?php
                        $setting = [];
                        if ($info->status_gelombang === 'Buka') {
                            $setting = [
                                'status-color' => 'badge bg-success bg-opacity-10 text-success',
                                'status-value' => 'Buka',
                                'route' => route('edit_gelombang', ['id' => $info->id, 'param' => 'Tutup']),
                                'text-link' => 'Tutup',
                                'btn-link' => 'btn btn-danger btn-sm',
                            ];
                        } else {
                            $setting = [
                                'status-color' => 'badge bg-danger bg-opacity-10 text-danger',
                                'status-value' => 'Tutup',
                                'route' => route('edit_gelombang', ['id' => $info->id, 'param' => 'Buka']),
                                'text-link' => 'Buka',
                                'btn-link' => 'btn btn-success btn-sm',
                            ];
                        }
                        ?>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-semibold">{{ $info->gelombang }}</div>
                            </td>
                            <td>
                                <span class="{{ $setting['status-color'] }}">{{ $setting['status-value'] }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ $setting['route'] }}" class="{{ $setting['btn-link'] }}" title="{{ $setting['text-link'] }}">
                                    {{ $setting['text-link']}}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
