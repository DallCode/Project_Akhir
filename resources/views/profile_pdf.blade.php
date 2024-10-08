<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .profile-info {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Profil Pengguna</h1>
    <div class="profile-info">
        <p><strong>Nama:</strong> {{ $alumni->nama }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ $alumni->jenis_kelamin }}</p>
        <p><strong>Lokasi:</strong> {{ $alumni->lokasi }}</p>
        <p><strong>Alamat:</strong> {{ $alumni->alamat }}</p>
        <p><strong>Kontak:</strong> {{ $alumni->kontak }}</p>
        <p><strong>Keahlian:</strong> {{ $alumni->keahlian }}</p>
        <p><strong>Deskripsi:</strong> {{ $alumni->deskripsi }}</p>
        <h3>Riwayat Pendidikan Formal</h3>
        <ul>
            @foreach($alumni->pendidikanformal as $pendidikan)
                <li>{{ $pendidikan->gelar }} di {{ $pendidikan->institusi }} ({{ $pendidikan->tahun_lulus }})</li>
            @endforeach
        </ul>
        <h3>Riwayat Pendidikan Nonformal</h3>
        <ul>
            @foreach($alumni->pendidikannonformal as $pendidikanNonformal)
                <li>{{ $pendidikanNonformal->nama_kursus }} di {{ $pendidikanNonformal->institusi }} ({{ $pendidikanNonformal->tahun_lulus }})</li>
            @endforeach
        </ul>
        <h3>Pengalaman Kerja</h3>
        <ul>
            @foreach($alumni->kerja as $kerja)
                <li>{{ $kerja->posisi }} di {{ $kerja->perusahaan }} ({{ $kerja->tahun_mulai }} - {{ $kerja->tahun_selesai }})</li>
            @endforeach
        </ul>
    </div>
</body>
</html>
