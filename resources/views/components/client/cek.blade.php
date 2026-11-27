@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 500px">
            <h1 class="display-6">Cek Pendaftar SMAN 1 SINDANGKASIH</h1>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-12 table-responsive text-dark">
                <table class="table align-middle" id="data_pendaftar">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Siswa</th>
                            <th scope="col">Asal Sekolah</th>
                            <th scope="col">Gelombang</th>
                            <th scope="col">Status Berkas</th>
                            <th scope="col">Aksi / Status Seleksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nama_siswa }}</td>
                                <td>{{ $p->asal_sekolah }}</td>
                                <td>{{ $p->gelombang }}</td>
                                <td>
                                    @if($p->acc == '1')
                                        <span class="badge bg-success">Di ACC</span>
                                    @else
                                        <span class="badge bg-danger">Waiting</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->status_seleksi === 'pending' && $p->acc == '1')
                                        <span class="badge bg-warning text-dark">Menunggu Seleksi</span>
                                    @elseif(in_array($p->status_seleksi, ['diterima', 'ditolak']))
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNISN{{ $p->id }}">
                                            <i class="fas fa-download me-1"></i> Lihat Hasil
                                        </button>

                                        <!-- Modal Input NISN -->
                                        <div class="modal fade" id="modalNISN{{ $p->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $p->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content text-start">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel{{ $p->id }}">Verifikasi NISN</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('download', $p->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nisn_{{ $p->id }}" class="form-label">Masukkan NISN Siswa:</label>
                                                                <input type="text" id="nisn_{{ $p->id }}" name="nisn" class="form-control" placeholder="Contoh: 0012345678" required autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success">Verifikasi & Lihat Hasil</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">Menunggu ACC Berkas</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada data pendaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>