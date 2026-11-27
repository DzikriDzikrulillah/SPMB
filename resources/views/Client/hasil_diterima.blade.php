<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengumuman Kelulusan</title>
    <style>
        :root{--primary:#0d6efd;--accent:#0b2b40;--bg:#f6f7fb;--card:#ffffff}
        body{margin:0;font-family:Inter,Arial,Helvetica,sans-serif;background:var(--bg);color:#222}
        .wrap{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:36px}
        .card{background:var(--card);border-radius:12px;box-shadow:0 8px 24px rgba(15,23,42,.08);max-width:900px;width:100%;overflow:hidden}
        .kop{display:flex;gap:18px;align-items:center;padding:22px 28px}
        .kop img{width:84px;height:auto}
        .kop .info{flex:1}
        .kop h3{margin:0;font-size:18px;color:var(--accent)}
        .kop p{margin:2px 0;color:#556170;font-size:13px}
        .kop .meta{text-align:right;color:#67757f;font-size:13px}
        .divider{height:1px;background:#e6e9ef}
        .body{padding:28px}
        .title{margin:0 0 10px 0;font-size:20px;color:var(--accent);font-weight:800}
        .message{color:#475569;margin-bottom:18px}
        .details{background:#fbfdff;padding:16px;border-radius:8px;border:1px solid #eef3fb}
        .details p{margin:8px 0;color:#263238}
        .actions{text-align:center;margin-top:18px}
        .btn-primary{background:var(--primary);color:#fff;border:none;padding:10px 18px;border-radius:8px;font-weight:600;cursor:pointer}
        .muted{color:#6b7280;font-size:13px;text-align:center;margin-top:14px}
        @media (min-width:768px){.title{font-size:24px}}
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card" role="main">
            <div class="kop">
                <img src="{{ asset('images/logo.png') }}" alt="logo">
                <div class="info">
                    <h3>SMAN 1 SINDANGKASIH</h3>
                    <p>FORMULIR PENDAFTARAN</p>
                    <p>Jl. Pendidikan No. 10, Sindangkasih, Jawa Barat</p>
                </div>
                <div class="meta">
                    <div><strong>No Pendaftaran</strong></div>
                    <div>2026 : {{ $data->id }}</div>
                    <div style="margin-top:8px"><strong>Gelombang</strong></div>
                    <div>{{ $data->gelombang }}</div>
                </div>
            </div>
            <div class="divider"></div>

            <div class="body">
                <h1 class="title">SELAMAT! ANDA DINYATAKAN LULUS SELEKSI SPMB SMAN 1 SINDANGKASIH</h1>
                <p class="message">Terima kasih telah mengikuti proses seleksi. Berikut data hasil Anda.</p>

                <div class="details">
                    <p><strong>Nama murid:</strong> {{ $data->nama_siswa }}</p>
                    <p><strong>Nomor Pendaftaran:</strong> {{ $data->id }}</p>
                    <p><strong>Jalur Pendaftaran:</strong> {{ $data->jalur }}</p>
                    <p><strong>Jurusan:</strong> {{ $data->jurusan }}</p>
                    {{-- @if(optional($data->hasilWaspas)->qi)
                        <p><strong>Nilai WASPAS:</strong> {{ optional($data->hasilWaspas)->qi }}</p>
                    @endif --}}
                    @if(optional($data->hasilWaspas)->ranking_jalur)
                        <p><strong>Peringkat:</strong> {{ $data->hasilWaspas->ranking_jalur }}</p>
                    @endif
                </div>

                <div class="actions">
                    <form action="{{ route('download', $data->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        <input type="hidden" name="nisn" value="{{ $nisn }}">
                        <input type="hidden" name="download" value="1">
                        <button class="btn-primary" aria-label="Download Bukti Kelulusan">Download Bukti Kelulusan</button>
                    </form>
                </div>

                <p class="muted">Dokumen ini merupakan bukti kelulusan sementara.</p>
            </div>
        </div>
    </div>
</body>
</html>
