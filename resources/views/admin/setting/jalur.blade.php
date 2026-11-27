@extends('layouts.dashboard.app')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white border-0">
        <div>
            <h6 class="fw-bold mb-1">Data Jalur</h6>
            <small class="text-muted">Kelola jalur pendaftaran</small>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalJalur">
            <i class="bi bi-plus-circle"></i> Tambah Jalur
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="data_sekolah">
                <thead class="table-light">
                    <tr>
                        <th class="fw-semibold text-muted">No</th>
                        <th class="fw-semibold text-muted">Jalur</th>
                        <th class="fw-semibold text-muted">Deskripsi</th>
                        <th class="fw-semibold text-muted">Kuota</th>
                        <th class="fw-semibold text-muted text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $info)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-semibold">{{ $info->jalur }}</div>
                    </td>
                    <td>
                        <small class="text-muted">{{ Str::limit($info->deskripsi_jalur, 50) }}</small>
                    </td>
                    <td>
                        <span class="badge bg-info bg-opacity-10 text-info">{{ $info->kuota }}</span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="{{ route('edit_jalur', $info->id) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('hapus_jalur', $info->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm("Apakah Anda yakin ingin menghapus jalur ini?");
    }
</script>
@endsection
