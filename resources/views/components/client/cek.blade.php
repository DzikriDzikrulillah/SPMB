
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="container-xxl py-5">
    <div class="container">
      <div class="text-center mx-auto" style="max-width: 500px">
        <h1 class="display-6 mb-5">
          Cek Pendaftar SMAN 1 SINDANGKASIH
        </h1>
      </div>
      <div class="row g-4 justify-content-center ">
        <div class="col-md-12 table-responsive" style="color: #000000">
            <table class="table" id="data_pendaftar" style="color: #000000">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Asal Sekolah</th>
                        <th>Gelombang</th>
                        <th>Status</th>
                        <th>Penerimaan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $p)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$p->nama_siswa}}</td>
                            <td>{{$p->asal_sekolah}}</td>
                            <td>{{$p->gelombang}}</td>
                            <td>@if($p->acc == '1') <span class="badge bg-success">Di Acc</span> @else <span class="badge bg-danger">Waiting</span> @endif</td>

                            <td>@if($p->daful == '1') <span class="badge bg-success">Diterima</span> @else <span class="badge bg-danger">Belum Selesai</span>@endif</td>
                            <td>
                              @if($p->acc == '1' && $p->daful == '0')
                                <span class="badge bg-success">Di Acc</span>
                                <span class="badge bg-danger">Belum Daftar Ulang</span>
                                @elseif($p->acc == '1' && $p->daful == '1')
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNISN{{$p->id}}">
                                  <i class="fas fa-download"></i> Download Data
                              </button>
                                <!-- Modal Input NISN -->
                                <div class="modal fade" id="modalNISN{{$p->id}}" tabindex="-1" aria-labelledby="modalLabel{{$p->id}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{$p->id}}">Verifikasi NISN</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('download', $p->id) }}" method="POST">
                                                    @csrf
                                                    <label for="nisn">Masukkan NISN:</label>
                                                    <input type="text" name="nisn" class="form-control" required>
                                                    <input type="hidden" name="id" value="{{$p->id}}">
                                                    <button type="submit" class="btn btn-success mt-3">Verifikasi & Download</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else 
                                <span class="badge bg-danger">Waiting</span>
                                <span class="badge bg-danger">Waiting</span> 
                              @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>