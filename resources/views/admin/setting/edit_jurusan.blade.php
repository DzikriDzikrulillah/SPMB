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
              <div class="card-body">
                <h5 class="card-title fw-semibold">Edit Jurusan</h5>
                <form action="{{ route('update_jurusan', $jurusan->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="jurusan" class="{{ $errors->get('jurusan') ? 'text-danger' : '' }}">Nama Jurusan<sup class="text-danger">*</sup></label>
                    <input type="text" name="jurusan" id="jurusan" class="form-control {{ $errors->get('jurusan') ? 'is-invalid' : '' }}" value="{{ old('jurusan', $jurusan->jurusan) }}">
                    @if ($errors->get('jurusan'))
                    <div class="invalid-feedback text-danger">
                    @foreach ($errors->get('jurusan') as $message)
                        {{ $message }}
                    @endforeach
                    </div>
                    @endif
                  </div>
                  <div class="form-group mt-3">
                    <label for="deskripsi_jurusan" class="{{ $errors->get('deskripsi_jurusan') ? 'text-danger' : '' }}">Deskripsi Jurusan<sup class="text-danger">*</sup></label>
                    <textarea name="deskripsi_jurusan" id="deskripsi_jurusan" class="form-control {{ $errors->get('deskripsi_jurusan') ? 'is-invalid' : '' }}" rows="5">{{ old('deskripsi_jurusan', $jurusan->deskripsi_jurusan) }}</textarea>
                  
                    @if ($errors->get('deskripsi_jurusan'))
                    <div class="invalid-feedback text-danger">
                    @foreach ($errors->get('deskripsi_jurusan') as $message)
                        {{ $message }}
                    @endforeach
                    </div>
                    @endif</div>
                  <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Update Jurusan</button>
                    <a href="{{ route('jurusan') }}" class="btn btn-secondary">Batal</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- END OF CENTER CONTENT -->

      </section>
    </div>
  </div>
</div>
@endsection