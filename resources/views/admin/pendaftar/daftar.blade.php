@extends('layouts.dashboard.app')
@section('content')
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="main-content">
        <section class="section">
        <!-- MAIN OF CENTER CONTENT -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h1 class="text-center fs-10 mb-4">Form Pendaftaran</h1>
                  <x-dcore.daftar :jalur="$jalur" :jurusan="$jurusan" :gelombang="$gelombang" :form="$form" :button="$button"/>
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