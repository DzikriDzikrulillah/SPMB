<!-- Contact & Registration Section Start -->
<div class="container-xxl py-5 bg-white text-dark">
    <div class="container">
        <div class="row g-5">
            <!-- Left Info Column -->
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.3s">
                <h1 class="display-6 text-dark mb-4">
                    Segera daftarkan diri Anda di SMAN 1 SINDANGKASIH!
                </h1>
                <p class="text-muted mb-4">
                    Pendaftaran SPMB SMAN 1 Sindangkasih dibuka mulai tanggal 1 Januari 2026 hingga 31 Juli 2027. Informasi lebih lanjut dapat dilihat di website sekolah atau menghubungi kontak di bawah ini.
                </p>

                <!-- Address -->
                <div class="d-flex align-items-center mb-4">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary rounded-3" style="width: 50px; height: 50px;">
                        <i class="fa fa-map-marker-alt text-white fs-5"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-1 text-dark">Alamat</h5>
                        <p class="mb-0 text-muted">Jl. Raya Sindangkasih, Kec. Sindangkasih, Kabupaten Ciamis, Jawa Barat 46268</p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="d-flex align-items-center mb-4">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary rounded-3" style="width: 50px; height: 50px;">
                        <i class="fa fa-phone-alt text-white fs-5"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-1 text-dark">Nomor Telepon</h5>
                        <p class="mb-0 text-muted">(0265) 311765</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary rounded-3" style="width: 50px; height: 50px;">
                        <i class="fa fa-envelope-open text-white fs-5"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-1 text-dark">Email</h5>
                        <p class="mb-0 text-muted">info@sman1sindangkasih.sch.id</p>
                    </div>
                </div>
            </div>

            <!-- Right Form Column -->
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                <div class="bg-light rounded-3 p-4 p-sm-5 shadow-sm">
                    <div class="text-center mb-4">
                        <h2 class="text-dark">Hubungi Kami</h2>
                    </div>

                    @if(session('sukses'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('sukses') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form class="needs-validation" novalidate method="POST" action="{{ route('hub') }}">
                        @csrf
                        <div class="row g-3">
                            <!-- Full Name -->
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="text" name="nama" class="form-control" id="gname" placeholder="Nama Lengkap" required />
                                    <label for="gname">Nama Lengkap</label>
                                    <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control" id="gmail" placeholder="xxx@xxx.com" required />
                                    <label for="gmail">Email Valid</label>
                                    <div class="invalid-feedback">Masukkan email yang valid.</div>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="tel" name="nomor_hp" class="form-control" id="cname" placeholder="08xxxxxxxxx" required />
                                    <label for="cname">Nomor HP/WA</label>
                                    <div class="invalid-feedback">Nomor telepon wajib diisi.</div>
                                </div>
                            </div>

                            <!-- Category Selection -->
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <select name="untuk" class="form-select" id="cage" required>
                                        <option disabled selected value="">Pilih Tujuan...</option>
                                        <option value="Customer Services">Informasi Umum / CS</option>
                                        <option value="Technical Support">Bantuan Teknis</option>
                                    </select>
                                    <label for="cage">Pesan Untuk</label>
                                    <div class="invalid-feedback">Pilih salah satu tujuan pesan.</div>
                                </div>
                            </div>

                            <!-- Message Textarea -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea name="pesan" class="form-control" placeholder="Tulis pesan Anda..." id="message" style="height: 180px;" required></textarea>
                                    <label for="message">Pesan</label>
                                    <div class="invalid-feedback">Pesan tidak boleh kosong.</div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3 rounded-pill fw-bold" type="submit">
                                    Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact & Registration Section End -->

<!-- Client-side Validation Script -->
<script>
(function () {
    'use strict';
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>