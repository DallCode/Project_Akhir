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

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Loker</h3>
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
                    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addJobModal">Tambah Data Loker</button>
                    <thead>
                        <tr>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loker as $lowongan)
                        <tr>
                            <td>{{ $lowongan->jabatan }}</td>
                            <td>{{ $lowongan->status }}</td>
                            <td>
                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailjobModal{{ $lowongan->id_lowongan_pekerjaan }}">Detail</button>
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editjobModal{{ $lowongan->id_lowongan_pekerjaan }}">Edit</button>

                                <!-- Modal Detail -->
                                <div class="modal fade" id="detailjobModal{{ $lowongan->id_lowongan_pekerjaan }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel">Detail Lowongan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Jabatan:</strong> {{ $lowongan->jabatan }}</p>
                                                <p><strong>Jenis Waktu Pekerjaan:</strong> {{ $lowongan->jenis_waktu_pekerjaan }}</p>
                                                <p><strong>Deskripsi:</strong> {{ $lowongan->deskripsi }}</p>
                                                <p><strong>Tanggal Akhir:</strong> {{ $lowongan->tanggal_akhir }}</p>
                                                <p><strong>Status:</strong> {{ $lowongan->status }}</p>

                                                @if (file_exists(public_path("alasan_lowongan_{$lowongan->id_lowongan_pekerjaan}.txt")))
                                                    @php
                                                        $alasan = file_get_contents(public_path("alasan_lowongan_{$lowongan->id_lowongan_pekerjaan}.txt"));
                                                    @endphp
                                                    <div class="alert alert-info">
                                                        <strong>Alasan Tidak Dipublikasi:</strong> {{ $alasan }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editjobModal{{ $lowongan->id_lowongan_pekerjaan }}" tabindex="-1" aria-labelledby="editModalLabel{{ $lowongan->id_lowongan_pekerjaan }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $lowongan->id_lowongan_pekerjaan }}">Edit Lowongan: {{ $lowongan->jabatan }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('lowongan.update', $lowongan->id_lowongan_pekerjaan) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="jabatan{{ $lowongan->id_lowongan_pekerjaan }}" class="form-label">Jabatan Pekerjaan</label>
                                                        <input class="form-control" type="text" id="jabatan{{ $lowongan->id_lowongan_pekerjaan }}" name="jabatan" value="{{ $lowongan->jabatan }}" placeholder="Jabatan pekerjaan" required />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="jenis_waktu_pekerjaan{{ $lowongan->id_lowongan_pekerjaan }}" class="form-label">Jenis Waktu Pekerjaan</label>
                                                        <select class="form-control" id="jenis_waktu_pekerjaan{{ $lowongan->id_lowongan_pekerjaan }}" name="jenis_waktu_pekerjaan" required>
                                                            <option value="">Pilih Jenis Waktu Pekerjaan</option>
                                                            <option value="Waktu Kerja Standar (Full-Time)" {{ $lowongan->jenis_waktu_pekerjaan == 'Waktu Kerja Standar (Full-Time)' ? 'selected' : '' }}>Waktu Kerja Standar (Full-Time)</option>
                                                            <option value="Waktu Kerja Paruh Waktu (Part-Time)" {{ $lowongan->jenis_waktu_pekerjaan == 'Waktu Kerja Paruh Waktu (Part-Time)' ? 'selected' : '' }}>Waktu Kerja Paruh Waktu (Part-Time)</option>
                                                            <option value="Waktu Kerja Fleksibel (Flexible Hours)" {{ $lowongan->jenis_waktu_pekerjaan == 'Waktu Kerja Fleksibel (Flexible Hours)' ? 'selected' : '' }}>Waktu Kerja Fleksibel (Flexible Hours)</option>
                                                            <option value="Shift Kerja (Shift Work)" {{ $lowongan->jenis_waktu_pekerjaan == 'Shift Kerja (Shift Work)' ? 'selected' : '' }}>Shift Kerja (Shift Work)</option>
                                                            <option value="Waktu Kerja Bergilir (Rotating Shift)" {{ $lowongan->jenis_waktu_pekerjaan == 'Waktu Kerja Bergilir (Rotating Shift)' ? 'selected' : '' }}>Waktu Kerja Bergilir (Rotating Shift)</option>
                                                            <option value="Waktu Kerja Jarak Jauh (Remote work)" {{ $lowongan->jenis_waktu_pekerjaan == 'Waktu Kerja Jarak Jauh (Remote work)' ? 'selected' : '' }}>Waktu Kerja Jarak Jauh (Remote work)</option>
                                                            <option value="Waktu Kerja Kontrak (Contract Work)" {{ $lowongan->jenis_waktu_pekerjaan == 'Waktu Kerja Kontrak (Contract Work)' ? 'selected' : '' }}>Waktu Kerja Kontrak (Contract Work)</option>
                                                            <option value="Waktu Kerja Proyek (Project-Based Work)" {{ $lowongan->jenis_waktu_pekerjaan == 'Waktu Kerja Proyek (Project-Based Work)' ? 'selected' : '' }}>Waktu Kerja Proyek (Project-Based Work)</option>
                                                            <option value="Waktu Kerja Musiman (Seasonal Work)" {{ $lowongan->jenis_waktu_pekerjaan == 'Waktu Kerja Musiman (Seasonal Work)' ? 'selected' : '' }}>Waktu Kerja Musiman (Seasonal Work)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="deskripsi{{ $lowongan->id_lowongan_pekerjaan }}" class="form-label">Deskripsi Pekerjaan</label>
                                                        <textarea class="form-control" id="deskripsi{{ $lowongan->id_lowongan_pekerjaan }}" name="deskripsi" rows="4" required>{{ $lowongan->deskripsi }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tanggal_akhir{{ $lowongan->id_lowongan_pekerjaan }}" class="form-label">Tanggal Akhir Lowongan</label>
                                                        <input class="form-control" type="date" id="tanggal_akhir{{ $lowongan->id_lowongan_pekerjaan }}" name="tanggal_akhir" value="{{ $lowongan->tanggal_akhir }}" required />
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal untuk menambah data loker -->
<div class="modal fade" id="addJobModal" tabindex="-1" data-bs-backdrop="false" aria-labelledby="addJobModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJobModalLabel">Tambah Data Loker</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('lowongan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan Pekerjaan</label>
                        <input class="form-control" type="text" id="jabatan" name="jabatan" placeholder="Jabatan pekerjaan" autofocus required />
                    </div>
                    <div class="mb-3">
                        <label for="jenis_waktu_pekerjaan" class="form-label">Jenis Waktu Pekerjaan</label>
                        <select class="form-control" id="jenis_waktu_pekerjaan" name="jenis_waktu_pekerjaan" required>
                            <option value="" selected>Pilih Jenis Waktu Pekerjaan</option>
                            <option value="Waktu Kerja Standar (Full-Time)" >Waktu Kerja Standar (Full-Time)</option>
                            <option value="Waktu Kerja Paruh Waktu (Part-Time)">Waktu Kerja Paruh Waktu (Part-Time)</option>
                            <option value="Waktu Kerja Fleksibel (Flexible Hours)" >Waktu Kerja Fleksibel (Flexible Hours)</option>
                            <option value="Shift Kerja (Shift Work)">Shift Kerja (Shift Work)</option>
                            <option value="Waktu Kerja Bergilir (Rotating Shift)">Waktu Kerja Bergilir (Rotating Shift)</option>
                            <option value="Waktu Kerja Jarak Jauh (Remote work)" >Waktu Kerja Jarak Jauh (Remote work)</option>
                            <option value="Waktu Kerja Kontrak (Contract Work)">Waktu Kerja Kontrak (Contract Work)</option>
                            <option value="Waktu Kerja Proyek (Project-Based Work)">Waktu Kerja Proyek (Project-Based Work)</option>
                            <option value="Waktu Kerja Musiman (Seasonal Work)">Waktu Kerja Musiman (Seasonal Work)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Pekerjaan</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir Lowongan</label>
                        <input class="form-control" type="date" id="tanggal_akhir" name="tanggal_akhir" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
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
