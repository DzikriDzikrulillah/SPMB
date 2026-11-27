@include('components.dashboard.header')
    <head><style>
  @media (min-width: 1200px) {
    /* Paksa hapus kalkulasi header-height di desktop */
    .body-wrapper > .container-fluid {
      padding-top: 24px !important; /* Nilai padding atas yang normal & rapi */
    }
  }
</style>
    </head>
<!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    @include('components.dashboard.sidebar')
        <div class="body-wrapper">
            @include('components.dashboard.headbar')
            <div class="container-fluid">
            @include('components.dashboard.modal')
                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
@include('components.dashboard.footer')

