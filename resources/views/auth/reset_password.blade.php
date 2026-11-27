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
                                <h4 class="text-center mb-4">Reset Password</h4>
                                <form method="POST" action="{{ route('reset_password') }}">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ request()->email }}">

                                    <div class="form-group">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror" required>

                                        @error('password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror" required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block w-100 mt-3">
                                            Ganti Password
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
