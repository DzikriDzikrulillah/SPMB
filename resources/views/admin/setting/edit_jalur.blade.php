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
                <h5 class="card-title fw-semibold">Edit Jalur</h5>
                <form action="{{ route('update_jalur', $jalur->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="jalur" class="{{ $errors->get('jalur') ? 'text-danger' : '' }}">Nama Jalur<sup class="text-danger">*</sup></label>
                    <input type="text" name="jalur" id="jalur" class="form-control {{ $errors->get('jalur') ? 'is-invalid' : '' }}" value="{{ old('jalur', $jalur->jalur) }}">
                    @if ($errors->get('jalur'))
                    <div class="invalid-feedback text-danger">
                    @foreach ($errors->get('jalur') as $message)
                        {{ $message }}
                    @endforeach
                    </div>
                    @endif
                  </div>
                  <div class="form-group mt-3">
                    <label for="deskripsi_jalur" class="{{ $errors->get('deskripsi_jalur') ? 'text-danger' : '' }}">Deskripsi Jalur<sup class="text-danger">*</sup></label>
                    <textarea name="deskripsi_jalur" id="deskripsi_jalur" class="form-control {{ $errors->get('deskripsi_jalur') ? 'is-invalid' : '' }}" rows="5">{{ old('deskripsi_jalur', $jalur->deskripsi_jalur) }}</textarea>
                    @if ($errors->get('deskripsi_jalur'))
                    <div class="invalid-feedback text-danger">
                    @foreach ($errors->get('deskripsi_jalur') as $message)
                        {{ $message }}
                    @endforeach
                    </div>
                    @endif
                  </div>
                  <div class="form-group mt-3">
                    <label for="kuota" class="{{ $errors->get('kuota') ? 'text-danger' : '' }}">Kuota Jalur</label>
                    <input type="number" name="kuota" id="kuota" min="0" class="form-control {{ $errors->get('kuota') ? 'is-invalid' : '' }}" value="{{ old('kuota', $jalur->kuota ?? 0) }}">
                    @if ($errors->get('kuota'))
                    <div class="invalid-feedback text-danger">
                    @foreach ($errors->get('kuota') as $message)
                        {{ $message }}
                    @endforeach
                    </div>
                    @endif
                  </div>
                  <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Update Jalur</button>
                    <a href="{{ route('jalur') }}" class="btn btn-secondary">Batal</a>
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
