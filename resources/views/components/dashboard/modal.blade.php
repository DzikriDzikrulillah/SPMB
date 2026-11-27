<!-- Modal -->
<div class="modal fade" id="modalJurusan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <form action="{{route('add_jurusan')}}" method="POST">
        @csrf
      <div class="modal-body">
      <h5 class="modal-title mb-3" id="exampleModalLabel">Jurusan<sup class="text-danger">*</sup></h5>
        <div class="form-group">
            <input type="text" name="jurusan" placeholder="Masukan Jurusan" class="form-control  @error('jurusan') is-invalid @enderror">
            @error('jurusan')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        <div class="form-group mt-2">
          <label>Deskripsi Jurusan<sup class="text-danger">*</sup></label>
          <textarea name="deskripsi_jurusan" class="form-control  @error('deskripsi_jurusan') is-invalid @enderror" id="konten" cols="30" rows="10"></textarea>
          @error('deskripsi_jurusan')
          <div class="invalid-feedback">{{$message}}</div>
          @enderror
        </div>
      </div>
      <div class="modal-footer">
        <a href="{{ route('jurusan') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Tambah Jurusan</button>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalJalur" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <form action="{{route('add_jalur')}}" method="POST">
        @csrf
      <div class="modal-body">
      <h5 class="modal-title mb-3" id="exampleModalLabel">Jalur<sup class="text-danger">*</sup></h5>
        <div class="form-group">
            <input type="text" name="jalur" placeholder="Masukan jalur" class="form-control  @error('jalur') is-invalid @enderror">
            @error('jalur')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        <div class="form-group mt-2">
          <label>Deskripsi Jalur<sup class="text-danger">*</sup></label>
          <textarea name="deskripsi_jalur" class="form-control @error('deskripsi_jalur') is-invalid @enderror" id="konten" cols="30" rows="10"></textarea>
          @error('deskripsi_jalur')
          <div class="invalid-feedback">{{$message}}</div>
          @enderror
        </div>
      </div>
      <div class="modal-footer">
        <a href="{{ route('jalur') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Tambah Jalur</button>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Seleksi semua form dalam modal
    document.querySelectorAll("form").forEach(function (form) {
        form.addEventListener("submit", function (event) {
            let isValid = true;
            let errorMessage = "Harap isi semua kolom yang bertanda *.";

            // Seleksi semua input dan textarea dalam form
            form.querySelectorAll("input, textarea").forEach(function (field) {
                if (field.value.trim() === "") {
                    isValid = false;
                    field.classList.add("is-invalid"); // Tambahkan kelas Bootstrap untuk error
                } else {
                    field.classList.remove("is-invalid");
                }
            });

            if (!isValid) {
                event.preventDefault(); // Mencegah form dikirim jika ada kolom kosong
                alert(errorMessage);
            }
        });
    });
});
</script>
