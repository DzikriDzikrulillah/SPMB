<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('img/icon/favicon.ico')}}" type="img/icon">
    <title>{{ $data->nama_siswa }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-direction: column;
        }
        .logo {
            width: 100px;
            height: auto;
            margin-left: 60px;
        }
        .judul {
            text-align: center;
            flex-grow: 1;
            margin-right: 80px;
        }
        .judul h1 {
            font-size: 24px;
            margin: 0;
        }
        .judul p {
            font-size: 14px;
            margin: 5px 0;
        }
        .judul .alamat {
            font-size: 12px;
        }
        .garis {
            border-top: 2px solid black;
            margin-top: 10px;
        }
        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        table td {
            padding: 5px 10px;
            vertical-align: top;
            font-size: 14px;
        }
        table td:first-child {
            width: 30%; /* Lebar kolom label */
            font-size: 14px;
        }
        table td:nth-child(2) {
            width: 5%; /* Lebar untuk titik dua */
            text-align: center;
            font-size: 14px;
        }
        table td:last-child {
            width: 65%; /* Lebar kolom nilai */
            font-size: 14px;
        }
        table tr {
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100px; text-align: left;">
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            </td>
            <td style="text-align: left;">
                <div class="judul">
                    <h1>SMAN 1 SINDANGKASIH</h1>
                    <p>FORMULIR PENDAFTARAN</p>
                    <p class="alamat">Jl. Pendidikan No. 10, Sindangkasih, Jawa Barat</p>
                    <p>Email: info@sman1sindangkasih.sch.id | Telepon: (0265) 123456</p>
                </div>
            </td>
        </tr>
    </table>
    
    <div class="garis"></div>
    
    <table>
        <tr>
            <td><b>No Pendaftaran</b></td>
            <td>:</td>
            <td>2025 : {{$data->id}}</td>
        </tr>
        <tr>
            <td><b>Gelombang</b></td>
            <td>:</td>
            <td>{{ $data->gelombang }}</td>
        </tr>
        <tr>
            <td><b>Jurusan Di Ambil</b></td>
            <td>:</td>
            <td>{{ $data->jurusan }}</td>
        </tr>
        <tr>
            <td><b>Lewat Jalur Pendaftaran</b></td>
            <td>:</td>
            <td>{{ $data->jalur }}</td>
        </tr>
        <tr>
            <td><b>Status Di Terima</b></td>
            <td>:</td>
            <td>@if($data->acc == '1' && $data->daful == '1' ) Selamat Untuk Ananda {{$data->nama_siswa}} Telah Di Terima Di SMAN 1 Sindangkasih.@endif</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="3" style="text-transform: uppercase;">
                <b>A. Identitas Pribadi</b>
            </td>
        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $data->nama_siswa }}</td>
        </tr>
        <tr>
            <td>Asal Sekolah</td>
            <td>:</td>
            <td>{{ $data->asal_sekolah }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $data->nik }}</td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>:</td>
            <td>{{ $data->nisn }}</td>
        </tr>
        <tr>
            <td>Lahir</td>
            <td>:</td>
            <td>{{ $data->tempat_lahir }}, {{$data->tanggal_lahir}}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->jenis_kelamin }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $data->agama }}</td>
        </tr>
        <tr>
            <td>Jumlah Saudara</td>
            <td>:</td>
            <td>{{ $data->saudara }}</td>
        </tr>
        <tr>
            <td>Anak ke</td>
            <td>:</td>
            <td>{{ $data->anak_ke }}</td>
        </tr>
        <tr>
            <td>Alamat Siswa</td>
            <td>:</td>
            <td>{{ $data->alamat }}</td>
        </tr>
        <tr>
            <td>No Hp Siswa</td>
            <td>:</td>
            <td>{{ $data->hp_siswa }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{ $data->email }}</td>
        </tr>
        <tr>
            <td>Jarak</td>
            <td>:</td>
            <td>{{ $data->jarak }} KM</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $data->alamat }}</td>
        </tr>
    </table>

    <table style="margin-top: 1em;">
        <tr>
            <td colspan="3" style="text-transform: uppercase;">
                <b>B. Identitas Orang Tua</b>
            </td>
        </tr>
        <tr>
            <td>Nama Ayah</td>
            <td>:</td>
            <td>{{ $data->nama_ayah }}</td>
        </tr>
        <tr>
            <td>Status Ayah</td>
            <td>:</td>
            <td>{{$data->status_ayah}}</td>
        </tr>
        <tr>
            <td>HP Ayah</td>
            <td>:</td>
            <td>{{$data->hp_ayah}}</td>
        </tr>
        <tr>
            <td>Penghasilan Ayah</td>
            <td>:</td>
            <td>{{$data->penghasilan_ayah}}</td>
        </tr>
        <tr>
            <td>Nama Ibu</td>
            <td>:</td>
            <td>{{ $data->nama_ibu }}</td>
        </tr>
        <tr>
            <td>Status Ibu</td>
            <td>:</td>
            <td>{{$data->status_ibu}}</td>
        </tr>
        <tr>
            <td>HP Ibu</td>
            <td>:</td>
            <td>{{$data->hp_ibu}}</td>
        </tr>
        <tr>
            <td>Penghasilan Ibu</td>
            <td>:</td>
            <td>{{$data->penghasilan_ibu}}</td>
        </tr>
    </table>

</body>
</html>
