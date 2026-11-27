{{ $page ?? $page = "" }}
<!-- Sidebar Start -->
<aside class="left-sidebar bg-light d-flex flex-column">
<!-- Sidebar scroll-->
<div class="d-flex flex-column h-100">
    <div class="brand-logo d-flex align-items-center justify-content-center mb-4">
    <a href="#" class="text-nowrap logo-img">
        <img class="mt-3" src="{{ asset('images/logo.png') }}" width="75" alt="" />
    </a>
    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
    </div>
</div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar flex-grow-1" data-simplebar="">
    <ul id="sidebarnav">
        <li class="sidebar-item">
        <a class="sidebar-link {{ $page === "dashboard" ? 'active' : '' }}" href="{{ route('home') }}" aria-expanded="false">
            <span>
            <i class="ti ti-layout-dashboard"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
        </a>
        </li>


<li class="sidebar-item">
    <a class="sidebar-link d-flex justify-content-between align-items-center
        {{ in_array($page, ['daftar_admin','pendaftar','pendaftar_terverifikasi']) ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#menu-pendaftaran"
       role="button"
       aria-expanded="{{ in_array($page, ['daftar_admin','pendaftar','pendaftar_terverifikasi']) ? 'true' : 'false' }}">

        <span>
            <i class="bi bi-person-lines-fill fs-6"></i>
            <span class="hide-menu ms-1">Pendaftaran</span>
        </span>

        <i class="bi bi-chevron-down small"></i>
    </a>

    <ul class="collapse first-level ms-3
        {{ in_array($page, ['daftar_admin','pendaftar','pendaftar_terverifikasi']) ? 'show' : '' }}"
        id="menu-pendaftaran">

        <li class="sidebar-item">
            <a class="sidebar-link {{ $page === 'daftar_admin' ? 'active' : '' }}"
               href="{{ route('daftar_admin') }}">
                <i class="bi bi-person-add fs-6"></i>
                <span class="hide-menu">Daftar Baru</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link {{ $page === 'pendaftar' ? 'active' : '' }}"
               href="{{ route('pendaftar.belum_acc') }}">
                <i class="bi bi-people-fill fs-6"></i>
                <span class="hide-menu">Pendaftar</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link {{ $page === 'pendaftar_terverifikasi' ? 'active' : '' }}"
               href="{{ route('pendaftar.terverifikasi') }}">
                <i class="bi bi-check-circle fs-6"></i>
                <span class="hide-menu">Data Terverifikasi</span>
            </a>
        </li>

    </ul>
</li>
<!-- Sidebar: Analisis & Perangkingan -->
<li class="sidebar-item">
    <a class="sidebar-link d-flex justify-content-between align-items-center
       {{ in_array($page, ['dm_proses','dm_hasil','spk_proses','spk_hasil']) ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#menu-analisis"
       role="button"
       aria-expanded="{{ in_array($page, ['dm_proses','dm_hasil','spk_proses','spk_hasil']) ? 'true' : 'false' }}">
        
        <span>
            <i class="bi bi-bar-chart-line fs-6"></i>
            <span class="hide-menu ms-1">Analisis & Perangkingan</span>
        </span>
        <i class="bi bi-chevron-down small"></i>
    </a>

    <ul class="collapse first-level ms-3
    {{ in_array($page, ['bobot','saw_hasil','wp_hasil','waspas_hasil']) ? 'show' : '' }}"
    id="menu-analisis">

    <li class="sidebar-item">
        <a class="sidebar-link {{ $page === 'bobot' ? 'active' : '' }}"
           href="{{ route('admin.analisis.bobot') }}">
            <i class="bi bi-sliders fs-6"></i>
            <span class="hide-menu">Atur Bobot</span>
        </a>
    </li>

    <li class="sidebar-item">
        <a class="sidebar-link {{ $page === 'waspas_hasil' ? 'active' : '' }}"
           href="{{ route('admin.analisis.waspas.index') }}">
            <i class="bi bi-trophy fs-6"></i>
            <span class="hide-menu">Hasil WASPAS</span>
        </a>
    </li>

</ul>
</li>

<!-- Sidebar: Data & Laporan -->
<li class="sidebar-item">
    <a class="sidebar-link d-flex justify-content-between align-items-center
       {{ in_array($page, ['diterima','laporan']) ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#menu-data-laporan"
       role="button"
       aria-expanded="{{ in_array($page, ['diterima','laporan']) ? 'true' : 'false' }}">

        <span>
            <i class="bi bi-folder-fill fs-6"></i>
            <span class="hide-menu ms-1">Data & Laporan</span>
        </span>
        <i class="bi bi-chevron-down small"></i>
    </a>

    <ul class="collapse first-level ms-3
        {{ in_array($page, ['diterima','laporan']) ? 'show' : '' }}"
        id="menu-data-laporan">

        <li class="sidebar-item">
            <a class="sidebar-link {{ $page === 'diterima' ? 'active' : '' }}"
               href="{{ route('admin.analisis.seleksi.index') }}">
                <i class="bi bi-mortarboard-fill fs-6"></i>
                <span class="hide-menu">Seleksi murid</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link {{ $page === 'laporan' ? 'active' : '' }}"
               href="{{ route('admin.analisis.laporan.index') }}">
                <i class="bi bi-file-earmark-excel fs-6"></i>
                <span class="hide-menu">Laporan & Export</span>
            </a>
        </li>

    </ul>
</li>

<li class="sidebar-item">
    <a class="sidebar-link d-flex justify-content-between align-items-center
       {{ in_array($page, ['jurusan','jalur','gelombang','informasi_sekolah','category_manager','kontak_admin']) ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#menu-settings"
       role="button">

        <span>
            <i class="bi bi-gear-fill fs-6"></i>
            <span class="hide-menu ms-1">Pengaturan</span>
        </span>
        <i class="bi bi-chevron-down small"></i>
    </a>

    <ul class="collapse first-level ms-3
        {{ in_array($page, ['jurusan','jalur','gelombang','informasi_sekolah','category_manager','kontak_admin']) ? 'show' : '' }}"
        id="menu-settings">

        <li class="sidebar-item">
            <a class="sidebar-link {{ $page === 'jurusan' ? 'active' : '' }}"
               href="{{ route('jurusan') }}">
                <i class="bi bi-mortarboard fs-6"></i>
                <span class="hide-menu">Jurusan</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link {{ $page === 'jalur' ? 'active' : '' }}"
               href="{{ route('jalur') }}">
                <i class="bi bi-sign-turn-slight-right fs-6"></i>
                <span class="hide-menu">Jalur</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link {{ $page === 'gelombang' ? 'active' : '' }}"
               href="{{ route('gelombang') }}">
                <i class="bi bi-arrow-clockwise fs-6"></i>
                <span class="hide-menu">Gelombang</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link {{ $page === 'informasi_sekolah' ? 'active' : '' }}"
               href="{{ route('informasi_sekolah') }}">
                <i class="bi bi-chat-square-text fs-6"></i>
                <span class="hide-menu">Blog</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link {{ $page === 'category_manager' ? 'active' : '' }}"
               href="{{ route('category_manager') }}">
                <i class="bi bi-info-circle fs-6"></i>
                <span class="hide-menu">Category</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link {{ $page === 'kontak_admin' ? 'active' : '' }}"
               href="{{ route('kontak_admin') }}">
                <i class="bi bi-envelope fs-6"></i>
                <span class="hide-menu">Kotak Masuk</span>
            </a>
        </li>

    </ul>
</li>

        <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        </li>
    </nav>
    <!-- End Sidebar navigation -->
    <div class="p-3 border-top mt-auto">
        <form action="{{ route('logout') }}" method="POST" class="js-confirm-form" data-confirm-title="Logout sekarang?" data-confirm-text="Sesi admin akan diakhiri.">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>
</div>
<!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->
