@extends('layouts.Dashboard')

@section('content')
    <link href="{{ asset('css/styles.min.css') }}" rel="stylesheet" />
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="d-flex align-items-center justify-content-center">
            <div class="d-flex w-100 min-vh-100 pb-5">
                <div class="row justify-content-center my-auto w-100 mx-auto rounded-lg">
                    <div class="col-md-7 col-lg-6 col-xxl-3">
                        <div class="card mb-0 mx-auto rounded-lg shadow">
                            <div class="card-body">
                                <a href="#" class="text-nowrap logo-img text-center d-block py-4 w-100">
                                    <img src="{{ asset('img/logo.png') }}" width="180" alt="" />
                                </a>
                                <h4 class="text-center mb-4">Lupa Password</h4>
                                <form method="POST" action="{{ url('/forgot-password') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email" class="form-label">Masukkan Email Anda</label>
                                        <input type="email" id="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" required autofocus>

                                        @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block w-100 mt-3">
                                            Lanjutkan
                                        </button>
                                    </div>
                                </form>

                                <div class="text-center mt-3">
                                    <a href="{{ route('login') }}" class="btn btn-link">Kembali ke Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
