@extends('layout.main')

@section('content')
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('bkk/dist/assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">
    <style>
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: linear-gradient(45deg, #3a7bd5, #00d2ff);
            border-bottom: none;
            padding: 20px;
        }

        .modal-title {
            font-weight: 700;
            letter-spacing: 1px;
        }

        .modal-body {
            padding: 30px;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            color: #333;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .info-value {
            color: #333;
        }

        .tag {
            display: inline-block;
            background-color: #f0f0f0;
            color: #333;
            padding: 5px 10px;
            border-radius: 20px;
            margin-right: 5px;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .timeline-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 20px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #3a7bd5;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 22px;
            bottom: -10px;
            width: 2px;
            background-color: #e0e0e0;
        }

        .timeline-item:last-child::after {
            display: none;
        }
    </style>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Lamaran Masuk</h3>
                    <p class="text-subtitle text-muted">For users to check their list</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    Simple Datatable
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama Pelamar</th>
                                <th>Posisi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lamaran as $lamar)
                                <tr>
                                    <td>{{ $lamar->alumni->nama }}</td>
                                    <td>{{ $lamar->loker->jabatan }}</td>
                                    <td>{{ $lamar->status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalDetail{{ $lamar->id_lamaran }}">
                                            Detail
                                        </button>
                                        @if ($lamar->status == 'Terkirim')
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalLolos{{ $lamar->id_lamaran }}">
                                                Lolos Ke Tahap Selanjutnya
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalTolak{{ $lamar->id_lamaran }}">
                                                Tolak
                                            </button>
                                        @elseif($lamar->status == 'Lolos Ketahap Selanjutnya')
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalTerima{{ $lamar->id_lamaran }}">
                                                Terima
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalTolak{{ $lamar->id_lamaran }}">
                                                Tolak
                                            </button>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @foreach ($lamaran as $lamar)
                        <!-- Modal Detail -->
                        <div class="modal fade" id="modalDetail{{ $lamar->id_lamaran }}" tabindex="-1"
                            data-bs-backdrop="static" aria-labelledby="modalDetailLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-white" id="modalDetailLabel">Detail Pelamar</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-4">
                                            <div class="col-md-4 text-center">
                                                <img src="{{ $lamar->alumni->foto ? asset('storage/foto/' . $lamar->alumni->foto) : ($lamar->alumni->jenis_kelamin == 'Laki Laki' ? asset('bkk/dist/assets/images/faces/4.jpg') : asset('bkk/dist/assets/images/faces/3.jpg')) }}"
                                                    class="profile-img rounded-circle mb-3" alt="Profile Image">
                                                <h4 class="mb-0">{{ $lamar->alumni->nama }}</h4>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="section-title">Informasi Dasar</h6>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="info-item">
                                                            <span class="info-label">Jenis Kelamin:</span>
                                                            <span
                                                                class="info-value">{{ $lamar->alumni->jenis_kelamin }}</span>
                                                        </div>
                                                        <div class="info-item">
                                                            <span class="info-label">Lokasi:</span>
                                                            <span class="info-value">{{ $lamar->alumni->lokasi }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="info-item">
                                                            <span class="info-label">Alamat:</span>
                                                            <span class="info-value">{{ $lamar->alumni->alamat }}</span>
                                                        </div>
                                                        <div class="info-item">
                                                            <span class="info-label">Kontak:</span>
                                                            <span class="info-value">{{ $lamar->alumni->kontak }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <h6 class="section-title">Pendidikan Formal</h6>
                                            @foreach ($lamar->alumni->pendidikanformal as $pendidikan)
                                                <div class="timeline-item">
                                                    <strong>{{ $pendidikan->tingkat_pendidikan }} -
                                                        {{ $pendidikan->nama_sekolah }}</strong>
                                                    <p class="mb-0">{{ $pendidikan->gelar }} -
                                                        {{ $pendidikan->bidang_studi }}</p>
                                                    <small class="text-muted">{{ $pendidikan->tahun_awal }} -
                                                        {{ $pendidikan->tahun_akhir }}</small>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mb-4">
                                            <h6 class="section-title">Pendidikan Non Formal</h6>
                                            @foreach ($lamar->alumni->pendidikannonformal as $kursus)
                                                <div class="timeline-item">
                                                    <strong>{{ $kursus->nama_lembaga }}</strong>
                                                    <p class="mb-0">{{ $kursus->kursus }}</p>
                                                    <small class="text-muted">{{ $kursus->tanggal }}</small>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mb-4">
                                            <h6 class="section-title">Keahlian</h6>
                                            @foreach (explode(',', $lamar->alumni->keahlian) as $skill)
                                                <span class="tag">{{ trim($skill) }}</span>
                                            @endforeach
                                        </div>

                                        <div class="mb-4">
                                            <h6 class="section-title">Pengalaman Kerja</h6>
                                            @foreach ($lamar->alumni->kerja as $pekerjaan)
                                                <div class="timeline-item">
                                                    <strong>{{ $pekerjaan->jabatan }}</strong>
                                                    <p class="mb-0">{{ $pekerjaan->nama_perusahaan }}</p>
                                                    <small class="text-muted">{{ $pekerjaan->tahun_awal }} -
                                                        {{ $pekerjaan->tahun_akhir }}</small>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div>
                                            <h6 class="section-title">Deskripsi</h6>
                                            <p>{{ $lamar->alumni->deskripsi }}</p>
                                        </div>

                                        <!-- Bagian File Tambahan -->
                                        <div class="mb-4">
                                            <h6 class="section-title">File Tambahan</h6>
                                            @if ($lamar->filelamar && $lamar->filelamar->count() > 0)
                                                <ul>
                                                    @foreach ($lamar->filelamar as $file)
                                                        <li>
                                                            <a href="{{ asset('storage/lamaran/' . $file->nama_file) }}"
                                                                target="_blank">
                                                                {{ $file->nama_file }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p>Tidak ada file tambahan yang diunggah.</p>
                                            @endif
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Modal Lolos Ke Tahap Selanjutnya -->
                        <div class="modal fade" id="modalLolos{{ $lamar->id_lamaran }}" tabindex="-1"
                            data-bs-backdrop="static" aria-labelledby="modalLolosLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLolosLabel">Lolos Ke Tahap Selanjutnya</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('updatestatus', $lamar->id_lamaran) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <input type="hidden" name="status" value="Lolos Ketahap Selanjutnya">
                                            <div class="form-group">
                                                <label for="alasan">Alasan Perubahan Status</label>
                                                <textarea name="alasan" id="alasan" rows="4" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Terima -->
                        <div class="modal fade" id="modalTerima{{ $lamar->id_lamaran }}" tabindex="-1"
                            data-bs-backdrop="static" aria-labelledby="modalTerimaLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTerimaLabel">Terima Lamaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('updatestatus', $lamar->id_lamaran) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <input type="hidden" name="status" value="Diterima">
                                            <div class="form-group">
                                                <label for="alasan">Alasan Penerimaan</label>
                                                <textarea name="alasan" id="alasan" rows="4" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Konfirmasi Terima</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Tolak -->
                        <div class="modal fade" id="modalTolak{{ $lamar->id_lamaran }}" tabindex="-1"
                            data-bs-backdrop="static" aria-labelledby="modalTolakLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTolakLabel">Tolak Lamaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('updatestatus', $lamar->id_lamaran) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <input type="hidden" name="status" value="Ditolak">
                                            <div class="form-group">
                                                <label for="alasan">Alasan Penolakan</label>
                                                <textarea name="alasan" id="alasan" rows="4" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Konfirmasi Tolak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </div>


    <script src="{{ asset('bkk/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('bkk/dist/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('bkk/dist/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        @if (session('success') || session('error'))
            Toastify({
                text: "{{ session('success') ? session('success') : session('error') }}",
                duration: 3000,
                close: true,
                gravity: "top", // 'top' or 'bottom'
                position: 'right', // 'left', 'center' or 'right'
                backgroundColor: "{{ session('success') ? '#4CAF50' : '#F44336' }}", // Hijau untuk success, Merah untuk error
                stopOnFocus: true, // Prevents dismissing of toast on hover
            }).showToast();
        @endif
    </script>


    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

    <script src="{{ asset('bkk/dist/assets/js/main.js') }}"></script>
@endsection
