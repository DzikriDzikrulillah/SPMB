@extends('layouts.dashboard.app')
@section('content')
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <div class="main-content">
        <section class="section">

        <!-- MAIN OF CENTER CONTENT -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body table-responsive">
                  <div class="d-flex justify-content-between">
                  <h5 class="card-title fw-semibold">Data Jalur</h5>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalJalur">
                    <i class="bi bi-plus-circle"></i> Tambah Jalur
                  </button>
                  </div>
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <table class="table table-borderless" id="data_sekolah">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Jalur </th>
                                  <th>Option</th>
                                </tr>
                              </thead>
                              <tbody>
                              @foreach($data as $info)
                              <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$info->jalur}}</td>
                                <td>
                                  <a href="{{ route('edit_jalur', $info->id) }}" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
                                  <form action="{{ route('hapus_jalur', $info->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                  </form>
                                </td>
                              </tr>
                              @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        <!-- END OF CENTER CONTENT -->

        </section>
      </div>
    </div>
  </div>

  <script>
    function confirmDelete() {
      return confirm("Apakah Anda yakin ingin menghapus jalur ini?");
    }
  </script>

@endsection
